<?php

namespace InteractiveValley\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use InteractiveValley\BackendBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\BackendBundle\Entity\Usuario;
use InteractiveValley\BackendBundle\Form\UsuarioType;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Usuario controller.
 *
 * @Route("/backend/usuarios")
 */
class UsuarioController extends BaseController
{

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuarios")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) 
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackendBundle:Usuario')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/", name="usuarios_create")
     * @Method("POST")
     * @Template("BackendBundle:Usuario:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $data = $form->getData();
        $password = $data->getPassword();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->setSecurePassword($entity);
            $em->persist($entity);
            $em->flush();
            //$this->enviarUsuarioCreado($data->getEmail(), $password, $entity);
            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_create'),
            'method' => 'POST'
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="usuarios_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Usuario();
        $entity->setGrupo(Usuario::GRUPO_USUARIOS);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="usuarios_show",requirements= {"id":"\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="usuarios_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm),
        );
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuarios_update', array('id' => $entity->getId())),
            'method' => 'PUT'
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}", name="usuarios_update")
     * @Method("PUT")
     * @Template("BackendBundle:Usuario:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        //obtiene la contraseña actual
        $current_pass = $entity->getPassword();
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            if (null == $entity->getPassword()) {
                // El usuario no cambia su contraseña.
                $entity->setPassword($current_pass);
            } else {
                // actualizamos la contraseña.
                $this->setSecurePassword($entity);
            }
            $em->flush();
            //$this->enviarUsuarioUpdate($entity->getEmail(), $current_pass, $entity);
            return $this->redirect($this->generateUrl('usuarios_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm),
        );
    }
    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="usuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuarios'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuarios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    
    
    /**
     * Exportar los usuarios.
     *
     * @Route("/exportar", name="usuarios_exportar")
     */
    public function exportarAction(Request $request)
    {
        $usuarios = $this->getDoctrine()->getRepository('BackendBundle:Usuario')
                         ->findBy(array('grupo' => Usuario::GRUPO_USUARIOS));

        $response = $this->render(
                'BackendBundle:Usuario:list.xls.twig', array('entities' => $usuarios)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-usuarios.xls"');
        return $response;
    }
    
    
}
