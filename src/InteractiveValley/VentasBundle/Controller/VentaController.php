<?php

namespace InteractiveValley\VentasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\VentasBundle\Entity\Venta;
use InteractiveValley\VentasBundle\Form\VentaType;

/**
 * Venta controller.
 *
 * @Route("/ventas")
 */
class VentaController extends Controller
{

    /**
     * Lists all Venta entities.
     *
     * @Route("/", name="ventas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VentasBundle:Venta')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Venta entity.
     *
     * @Route("/", name="ventas_create")
     * @Method("POST")
     * @Template("VentasBundle:Venta:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Venta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ventas_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Venta entity.
     *
     * @param Venta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Venta $entity)
    {
        $form = $this->createForm(new VentaType(), $entity, array(
            'action' => $this->generateUrl('ventas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Venta entity.
     *
     * @Route("/new", name="ventas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Venta();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Venta entity.
     *
     * @Route("/{id}", name="ventas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Venta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Venta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Venta entity.
     *
     * @Route("/{id}/edit", name="ventas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Venta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Venta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Venta entity.
    *
    * @param Venta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Venta $entity)
    {
        $form = $this->createForm(new VentaType(), $entity, array(
            'action' => $this->generateUrl('ventas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Venta entity.
     *
     * @Route("/{id}", name="ventas_update")
     * @Method("PUT")
     * @Template("VentasBundle:Venta:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Venta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Venta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ventas_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Venta entity.
     *
     * @Route("/{id}", name="ventas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VentasBundle:Venta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Venta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ventas'));
    }

    /**
     * Creates a form to delete a Venta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ventas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
