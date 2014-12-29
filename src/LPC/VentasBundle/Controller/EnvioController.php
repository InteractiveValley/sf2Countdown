<?php

namespace LPC\VentasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LPC\VentasBundle\Entity\Envio;
use LPC\VentasBundle\Form\EnvioType;

/**
 * Envio controller.
 *
 * @Route("/envio")
 */
class EnvioController extends Controller
{

    /**
     * Lists all Envio entities.
     *
     * @Route("/", name="envio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VentasBundle:Envio')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Envio entity.
     *
     * @Route("/", name="envio_create")
     * @Method("POST")
     * @Template("VentasBundle:Envio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Envio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('envio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Envio entity.
     *
     * @param Envio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Envio $entity)
    {
        $form = $this->createForm(new EnvioType(), $entity, array(
            'action' => $this->generateUrl('envio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Envio entity.
     *
     * @Route("/new", name="envio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Envio();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Envio entity.
     *
     * @Route("/{id}", name="envio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Envio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Envio entity.
     *
     * @Route("/{id}/edit", name="envio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Envio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envio entity.');
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
    * Creates a form to edit a Envio entity.
    *
    * @param Envio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Envio $entity)
    {
        $form = $this->createForm(new EnvioType(), $entity, array(
            'action' => $this->generateUrl('envio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Envio entity.
     *
     * @Route("/{id}", name="envio_update")
     * @Method("PUT")
     * @Template("VentasBundle:Envio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VentasBundle:Envio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('envio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Envio entity.
     *
     * @Route("/{id}", name="envio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VentasBundle:Envio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Envio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('envio'));
    }

    /**
     * Creates a form to delete a Envio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('envio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
