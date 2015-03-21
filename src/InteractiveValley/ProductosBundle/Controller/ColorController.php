<?php

namespace InteractiveValley\ProductosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\ProductosBundle\Entity\Color;
use InteractiveValley\ProductosBundle\Form\ColorType;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Color controller.
 *
 * @Route("/backend/colores")
 */
class ColorController extends Controller
{
    
    /**
     * Lists all Color entities.
     *
     * @Route("/", name="colores")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProductosBundle:Color')->findBy(array(),array(
            'position'=>'ASC'
        ));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Color entity.
     *
     * @Route("/", name="colores_create")
     * @Method("POST")
     * @Template("ProductosBundle:Color:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Color();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('colores_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores' => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Creates a form to create a Color entity.
     *
     * @param Color $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Color $entity)
    {
        $form = $this->createForm(new ColorType(), $entity, array(
            'action' => $this->generateUrl('colores_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Color entity.
     *
     * @Route("/new", name="colores_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Color();
        $max = $this->getDoctrine()->getRepository('ProductosBundle:Color')
                    ->getMaxPosicion();
        if (!is_null($max)) {
            $entity->setPosition($max + 1);
        } else {
            $entity->setPosition(1);
        }
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores'     => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Finds and displays a Color entity.
     *
     * @Route("/{id}", name="colores_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Color')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Color entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Color entity.
     *
     * @Route("/{id}/edit", name="colores_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Color')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Color entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'      => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores'     => RpsStms::getErrorMessages($editForm),
        );
    }

    /**
    * Creates a form to edit a Color entity.
    *
    * @param Color $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Color $entity)
    {
        $form = $this->createForm(new ColorType(), $entity, array(
            'action' => $this->generateUrl('colores_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Color entity.
     *
     * @Route("/{id}", name="colores_update")
     * @Method("PUT")
     * @Template("ProductosBundle:Color:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Color')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Color entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('colores_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores'     => RpsStms::getErrorMessages($editForm),
        );
    }
    /**
     * Deletes a Color entity.
     *
     * @Route("/{id}", name="colores_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProductosBundle:Color')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Color entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('colores'));
    }

    /**
     * Creates a form to delete a Color entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('colores_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Exportar los colores.
     *
     * @Route("/exportar", name="colores_exportar")
     */
    public function exportarAction(Request $request)
    {
        $colores = $this->getDoctrine()->getRepository('ProductosBundle:Color')
                         ->findAll();

        $response = $this->render(
                'ProductosBundle:Color:list.xls.twig', array('entities' => $colores)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-colores.xls"');
        return $response;
    }
    
    /**
     * Ordenar las posiciones de las colores de productos.
     *
     * @Route("/ordenar/registros", name="colores_ordenar")
     * @Method("PATCH")
     */
    public function ordenarRegistrosAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $registro_order = $request->query->get('registro');
            $em = $this->getDoctrine()->getManager();
            $result['ok'] = true;
            foreach ($registro_order as $order => $id) {
                $registro = $em->getRepository('ProductosBundle:Color')->find($id);
                if ($registro->getPosition() != ($order + 1)) {
                    try {
                        $registro->setPosition($order + 1);
                        $em->flush();
                    } catch (Exception $e) {
                        $result['mensaje'] = $e->getMessage();
                        $result['ok'] = false;
                    }
                }
            }
            $response = new \Symfony\Component\HttpFoundation\JsonResponse();
            $response->setData($result);
            return $response;
        } else {
            $response = new \Symfony\Component\HttpFoundation\JsonResponse();
            $response->setData(array('ok' => false));
            return $response;
        }
    }
}
