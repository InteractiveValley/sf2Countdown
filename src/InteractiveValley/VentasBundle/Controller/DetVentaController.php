<?php

namespace InteractiveValley\VentasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\VentasBundle\Entity\DetVenta;
use InteractiveValley\VentasBundle\Form\DetVentaType;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * DetVenta controller.
 *
 * @Route("/backend/detventas")
 */
class DetVentaController extends Controller
{

    /**
     * Lists all DetVenta entities.
     *
     * @Route("/", name="detventas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VentasBundle:DetVenta')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new DetVenta entity.
     *
     * @Route("/", name="detventas_create")
     * @Method("POST")
     * @Template("VentasBundle:DetVenta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new DetVenta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('detventas_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Creates a form to create a DetVenta entity.
     *
     * @param DetVenta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DetVenta $entity)
    {
        $form = $this->createForm(new DetVentaType(), $entity, array(
            'action' => $this->generateUrl('detventas_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DetVenta entity.
     *
     * @Route("/new", name="detventas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DetVenta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Finds and displays a DetVenta entity.
     *
     * @Route("/{id}", name="detventas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:DetVenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetVenta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing DetVenta entity.
     *
     * @Route("/{id}/edit", name="detventas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:DetVenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetVenta entity.');
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
    * Creates a form to edit a DetVenta entity.
    *
    * @param DetVenta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DetVenta $entity)
    {
        $form = $this->createForm(new DetVentaType(), $entity, array(
            'action' => $this->generateUrl('detventas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DetVenta entity.
     *
     * @Route("/{id}", name="detventas_update")
     * @Method("PUT")
     * @Template("VentasBundle:DetVenta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:DetVenta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DetVenta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('detventas_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores' => RpsStms::getErrorMessages($editForm),
        );
    }
    /**
     * Deletes a DetVenta entity.
     *
     * @Route("/{id}", name="detventas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VentasBundle:DetVenta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DetVenta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('detventas'));
    }

    /**
     * Creates a form to delete a DetVenta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detventas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Exportar los detVentas.
     *
     * @Route("/exportar", name="detventas_exportar")
     */
    public function exportarAction(Request $request)
    {
        $detventas = $this->getDoctrine()->getRepository('VentasBundle:DetVenta')
                         ->findAll();

        $response = $this->render(
                'VentasBundle:DetVenta:list.xls.twig', array('entities' => $detventas)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-detventas.xls"');
        return $response;
    }
}
