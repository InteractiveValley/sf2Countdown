<?php

namespace InteractiveValley\VentasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\VentasBundle\Entity\Direccion;
use InteractiveValley\VentasBundle\Form\DireccionType;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Direccion controller.
 *
 * @Route("/backend/direcciones")
 */
class DireccionController extends Controller
{
    
    private $usuarios = null;
    
    protected function getFilters() {
        return $this->get('session')->get('filters', array());
    }
    protected function setFilters($filtros) {
        $this->get('session')->set('filters', $filtros);
    }
    protected function getUsuarioDefault() {
        $filters = $this->getFilters();
        $cat = null;
        if (isset($filters['usuarios'])) {
            $usuarios = $this->getUsuariosDirecciones();
            foreach ($usuarios as $usuario) {
                if ($usuario->getId() == $filters['usuarios']) {
                    $cat = $usuario;
                    break;
                }
            }
        } else {
            $usuarios = $this->getUsuariosDirecciones();
            $this->setFilters(array('usuarios' => $usuarios[0]->getId()));
            $cat = $usuarios[0];
        }
        return $cat;
    }
    protected function getUsuariosDirecciones() {
        $em = $this->getDoctrine()->getManager();
        if ($this->usuarios == null) {
            $this->usuarios = $em->getRepository('BackendBundle:Usuario')
                    ->findAll();
        }
        return $this->usuarios;
    }
    protected function getUsuarioActual($usuarioId) {
        $usuarios = $this->getUsuariosDirecciones();
        $usuarioActual = null;
        foreach ($usuarios as $usuario) {
            if ($usuario->getId() == $usuarioId) {
                $usuarioActual = $usuario;
                break;
            }
        }
        return $usuarioActual;
    }

    /**
     * Lists all Direccion entities.
     *
     * @Route("/", name="direcciones")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $usuario = $this->getUsuarioDefault();
        
        /*$direcciones = $this->getDoctrine()->getRepository('VentasBundle:Direccion')
                        ->findByUsuario($usuario);*/
        
        return array(
            'usuario' =>  $usuario,
            'entities'  =>  $usuario->getDirecciones(),
        );
    }
    
    /**
     * Lista todas las direcciones de un usuario.
     *
     * @Route("/usuario/{id}", name="direcciones_usuario")
     * @Method("GET")
     * @Template("VentasBundle:Direccion:index.html.twig")
     */
    public function usuarioAction($id) {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('BackendBundle:Usuario')
                		->find($id);
        if (!$usuario) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }
        $filters = $this->getFilters();
        $filters['usuarios'] = $usuario->getId();
        $this->setFilters($filters);
        return array(
            'usuario' =>  $usuario,
            'entities'  =>  $usuario->getDirecciones(),
        );
    }
    
    /**
     * Creates a new Direccion entity.
     *
     * @Route("/", name="direcciones_create")
     * @Method("POST")
     * @Template("VentasBundle:Direccion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Direccion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('direcciones_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Creates a form to create a Direccion entity.
     *
     * @param Direccion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Direccion $entity)
    {
        $form = $this->createForm(new DireccionType(), $entity, array(
            'action' => $this->generateUrl('direcciones_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Direccion entity.
     *
     * @Route("/new", name="direcciones_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Direccion();
        $entity->setUsuario($this->getUsuarioDefault());
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Finds and displays a Direccion entity.
     *
     * @Route("/{id}", name="direcciones_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Direccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Direccion entity.
     *
     * @Route("/{id}/edit", name="direcciones_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Direccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direccion entity.');
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
    * Creates a form to edit a Direccion entity.
    *
    * @param Direccion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Direccion $entity)
    {
        $form = $this->createForm(new DireccionType(), $entity, array(
            'action' => $this->generateUrl('direcciones_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Direccion entity.
     *
     * @Route("/{id}", name="direcciones_update")
     * @Method("PUT")
     * @Template("VentasBundle:Direccion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Direccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('direcciones_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm),
        );
    }
    /**
     * Deletes a Direccion entity.
     *
     * @Route("/{id}", name="direcciones_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VentasBundle:Direccion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Direccion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('direcciones'));
    }

    /**
     * Creates a form to delete a Direccion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('direcciones_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Exportar los direcciones.
     *
     * @Route("/exportar", name="direcciones_exportar")
     */
    public function exportarAction(Request $request)
    {
        $direcciones = $this->getDoctrine()->getRepository('VentasBundle:Direccion')
                         ->findAll();

        $response = $this->render(
                'VentasBundle:Direccion:list.xls.twig', array('entities' => $direcciones)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-direcciones.xls"');
        return $response;
    }
}
