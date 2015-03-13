<?php

namespace InteractiveValley\ProductosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\ProductosBundle\Entity\Modelo;
use InteractiveValley\ProductosBundle\Form\ModeloType;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

/**
 * Modelo controller.
 *
 * @Route("/backend/modelos")
 */
class ModeloController extends Controller
{
    
    private $categorias = null;
    
    protected function getFilters() {
        return $this->get('session')->get('filters', array());
    }
    protected function setFilters($filtros) {
        $this->get('session')->set('filters', $filtros);
    }
    protected function getCategoriaDefault() {
        $filters = $this->getFilters();
        $cat = null;
        if (isset($filters['categorias'])) {
            $categorias = $this->getCategoriasModelos();
            foreach ($categorias as $categoria) {
                if ($categoria->getId() == $filters['categorias']) {
                    $cat = $categoria;
                    break;
                }
            }
        } else {
            $categorias = $this->getCategoriasModelos();
            $this->setFilters(array('categorias' => $categorias[0]->getId()));
            $cat = $categorias[0];
        }
        return $cat;
    }
    protected function getCategoriasModelos() {
        $em = $this->getDoctrine()->getManager();
        if ($this->categorias == null) {
            $this->categorias = $em->getRepository('ProductosBundle:Categoria')
                    ->findAll();
        }
        return $this->categorias;
    }
    protected function getCategoriaActual($categoriaId) {
        $categorias = $this->getCategoriasModelos();
        $categoriaActual = null;
        foreach ($categorias as $categoria) {
            if ($categoria->getId() == $categoriaId) {
                $categoriaActual = $categoria;
                break;
            }
        }
        return $categoriaActual;
    }


    /**
     * Lists all Modelo entities.
     *
     * @Route("/", name="modelos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $categoria = $this->getCategoriaDefault();
        return array(
            'categoria' =>  $categoria,
            'entities'  =>  $categoria->getModelos(),
        );
    }
    
    /**
     * Lista todos los modelos de una categoria.
     *
     * @Route("/categoria/{slug}", name="modelos_categoria")
     * @Method("GET")
     * @Template("ProductosBundle:Modelo:index.html.twig")
     */
    public function categoriaAction($slug) {
        $em = $this->getDoctrine()->getManager();
        $categoria = $em->getRepository('ProductosBundle:Categoria')
                		->findOneBy(array('slug' => $slug));
        if (!$categoria) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }
        $filters = $this->getFilters();
        $filters['categorias'] = $categoria->getId();
        $this->setFilters($filters);
        return array(
            'categoria' =>  $categoria,
            'entities'  =>  $categoria->getModelos(),
        );
    }
    
    /**
     * Creates a new Modelo entity.
     *
     * @Route("/", name="modelos_create")
     * @Method("POST")
     * @Template("ProductosBundle:Modelo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Modelo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->setNombreSluggable($entity,true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('modelos_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores'     => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Creates a form to create a Modelo entity.
     *
     * @param Modelo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Modelo $entity)
    {
        $form = $this->createForm(new ModeloType(), $entity, array(
            'action' => $this->generateUrl('modelos_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Modelo entity.
     *
     * @Route("/new", name="modelos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Modelo();
        $entity->setCategoria($this->getCategoriaDefault());
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores'     => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Finds and displays a Modelo entity.
     *
     * @Route("/{id}", name="modelos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Modelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Displays a form to edit an existing Modelo entity.
     *
     * @Route("/{id}/edit", name="modelos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Modelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modelo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores'     => RpsStms::getErrorMessages($editForm),
        );
    }

    /**
    * Creates a form to edit a Modelo entity.
    *
    * @param Modelo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Modelo $entity)
    {
        $form = $this->createForm(new ModeloType(), $entity, array(
            'action' => $this->generateUrl('modelos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Modelo entity.
     *
     * @Route("/{id}", name="modelos_update")
     * @Method("PUT")
     * @Template("ProductosBundle:Modelo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Modelo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modelo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->setNombreSluggable($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('modelos_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores'     => RpsStms::getErrorMessages($editForm),
        );
    }
    /**
     * Deletes a Modelo entity.
     *
     * @Route("/{id}", name="modelos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProductosBundle:Modelo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Modelo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('modelos'));
    }

    /**
     * Creates a form to delete a Modelo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modelos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Exportar los modelos.
     *
     * @Route("/exportar", name="modelos_exportar")
     */
    public function exportarAction(Request $request)
    {
        $modelos = $this->getDoctrine()->getRepository('ProductosBundle:Modelo')
                         ->findAll();

        $response = $this->render(
                'ProductosBundle:Modelo:list.xls.twig', array('entities' => $modelos)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-modelos.xls"');
        return $response;
    }
    
    private function setNombreSluggable(Modelo $entity, $isNew = false){
        $em = $this->getDoctrine()->getManager();
        $entity->setSlugAtValue();
        $slug = $entity->getSlug();
        $id = 0;
        if(!$isNew){ $id = $entity->getId(); }
        $resultados = $em->getRepository('ProductosBundle:Modelo')
                         ->findNombreSluggable($slug,$id);
        if(count($resultados)>0){
            $cont=0;
            $encontrado = false;
            do{
                //buscamos el slug correcto
                $slugBuscar = $slug .($cont>0?'-'.$cont:'');
                foreach($resultados as $resultado){
                    if($resultado->getSlug() == $slugBuscar){
                        $encontrado=true;
                        break;
                    }else{
                        $encontrado = false;
                    }
                }
                //entonces empecemos a buscar otro slug
                $cont++;
            }while($encontrado);
            $slug = $slugBuscar;    
        }   
        $entity->setSlug($slug);
        return true;
    }
}
