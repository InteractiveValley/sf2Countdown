<?php

namespace InteractiveValley\ProductosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use InteractiveValley\ProductosBundle\Entity\Producto;
use InteractiveValley\ProductosBundle\Form\ProductoType;

use InteractiveValley\BackendBundle\Utils\Richsys as RpsStms;

use InteractiveValley\BackendBundle\Utils\qqFileUploader;
use InteractiveValley\GaleriasBundle\Entity\Galeria;

/**
 * Producto controller.
 *
 * @Route("/backend/productos")
 */
class ProductoController extends Controller
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
            $categorias = $this->getCategoriasProductos();
            foreach ($categorias as $categoria) {
                if ($categoria->getId() == $filters['categorias']) {
                    $cat = $categoria;
                    break;
                }
            }
        } else {
            $categorias = $this->getCategoriasProductos();
            $this->setFilters(array('categorias' => $categorias[0]->getId()));
            $cat = $categorias[0];
        }
        return $cat;
    }
    protected function getCategoriasProductos() {
        $em = $this->getDoctrine()->getManager();
        if ($this->categorias == null) {
            $this->categorias = $em->getRepository('ProductosBundle:Categoria')
                    ->findAll();
        }
        return $this->categorias;
    }
    protected function getCategoriaActual($categoriaId) {
        $categorias = $this->getCategoriasProductos();
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
     * Lists all Producto entities.
     *
     * @Route("/", name="productos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $categoria = $this->getCategoriaDefault();
        return array(
            'categoria' =>  $categoria,
            'entities'  =>  $categoria->getProductos(),
        );
    }
    
    /**
     * Lista todos los productos de una categoria.
     *
     * @Route("/categoria/{slug}", name="productos_categoria")
     * @Method("GET")
     * @Template("ProductosBundle:Producto:index.html.twig")
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
            'entities'  =>  $categoria->getProductos(),
        );
    }
    
    /**
     * Creates a new Producto entity.
     *
     * @Route("/", name="productos_create")
     * @Method("POST")
     * @Template("ProductosBundle:Producto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Producto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->setNombreSluggable($entity,true);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productos_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores'     => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Creates a form to create a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('productos_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     * @Route("/new", name="productos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Producto();
        $entity->setCategoria($this->getCategoriaDefault());
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'errores'     => RpsStms::getErrorMessages($form),
        );
    }

    /**
     * Finds and displays a Producto entity.
     *
     * @Route("/{id}", name="productos_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'get_galerias' =>$this->generateUrl('productos_galerias',array('id'=>$entity->getId()),true),
            'post_galerias' =>$this->generateUrl('productos_galerias_upload', array('id'=>$entity->getId()),true),
            'post_galerias_link_video' =>$this->generateUrl('productos_galerias_link_video', array('id'=>$entity->getId()),true),
            'url_delete' => $this->generateUrl('productos_galerias_delete',array('id'=>$entity->getId(),'idGaleria'=>'0'),true),
        );
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     * @Route("/{id}/edit", name="productos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
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
    * Creates a form to edit a Producto entity.
    *
    * @param Producto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('productos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Producto entity.
     *
     * @Route("/{id}", name="productos_update")
     * @Method("PUT")
     * @Template("ProductosBundle:Producto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProductosBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $this->setNombreSluggable($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productos_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'errores'     => RpsStms::getErrorMessages($editForm),
        );
    }
    /**
     * Deletes a Producto entity.
     *
     * @Route("/{id}", name="productos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProductosBundle:Producto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productos'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Exportar los productos.
     *
     * @Route("/exportar", name="productos_exportar")
     */
    public function exportarAction(Request $request)
    {
        $productos = $this->getDoctrine()->getRepository('ProductosBundle:Producto')
                         ->findAll();

        $response = $this->render(
                'ProductosBundle:Producto:list.xls.twig', array('entities' => $productos)
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="export-productos.xls"');
        return $response;
    }
    
    /**
     * Lists all Producto galerias entities.
     *
     * @Route("/{id}/galerias", name="productos_galerias")
     * @Method("GET")
     */
    public function galeriasAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('ProductosBundle:Producto')->find($id);
        
        $galerias = $producto->getGalerias();
        $get_galerias = $this->generateUrl('productos_galerias',array('id'=>$producto->getId()),true);
        $post_galerias = $this->generateUrl('productos_galerias_upload', array('id'=>$producto->getId()),true);
	$post_galerias_link_video = $this->generateUrl('productos_galerias_link_video', array('id'=>$producto->getId()),true);
        $url_delete = $this->generateUrl('productos_galerias_delete',array('id'=>$producto->getId(),'idGaleria'=>'0'),true);
        
        return $this->render('GaleriasBundle:Galeria:galerias.html.twig', array(
            'galerias'=>$galerias,
            'get_galerias' =>$get_galerias,
            'post_galerias' =>$post_galerias,
            'post_galerias_link_video' =>$post_galerias_link_video,
            'url_delete' => $url_delete,
        ));
    }
    
    /**
     * Crea una galeria de una producto.
     *
     * @Route("/{id}/galerias", name="productos_galerias_upload")
     * @Method("POST")
     */
    public function galeriasUploadAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $producto=$em->getRepository('ProductosBundle:Producto')->find($id);
       
        if(!$request->request->has('tipoArchivo')){ 
            // list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $allowedExtensions = array("jpeg","png","gif","jpg");
            // max file size in bytes
            $sizeLimit = 6 * 1024 * 1024;
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit,$request->server);
            $uploads= $this->container->getParameter('richpolis.uploads');
            $result = $uploader->handleUpload($uploads."/galerias/");
            // to pass data through iframe you will need to encode all html tags
            /*****************************************************************/
            //$file = $request->getParameter("qqfile");
            $max = $em->getRepository('GaleriasBundle:Galeria')->getMaxPosicion();
            if($max == null){
                $max=0;
            }
            if(isset($result["success"])){
                $registro = new Galeria();
                $registro->setArchivo($result["filename"]);
                $registro->setThumbnail($result["filename"]);
                $registro->setTitulo($result["titulo"]);
                $registro->setIsActive(true);
                $registro->setPosition($max+1);
                $registro->setTipoArchivo(RpsStms::TIPO_ARCHIVO_IMAGEN);
                //unset($result["filename"],$result['original'],$result['titulo'],$result['contenido']);
                $em->persist($registro);
                $registro->crearThumbnail();    
                $producto->getGalerias()->add($registro);
                $em->flush();
            }
        }else{
            $result = $request->request->all(); 
            $registro = new Galeria();
            $registro->setArchivo($result["archivo"]);
            $registro->setIsActive($result['isActive']);
            $registro->setPosition($result['position']);
            $registro->setTipoArchivo($result['tipoArchivo']);
            $em->persist($registro);
            $producto->getGalerias()->add($registro);
            $em->flush();  
        }
        
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData($result);
        return $response;
    }
    
    /**
     * Crea una galeria link video de una producto.
     *
     * @Route("/{id}/galerias/link/video", name="productos_galerias_link_video", requirements={"id" = "\d+"})
     * @Method({"POST","GET"})
     */
    public function galeriasLinkVideoAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $producto=$em->getRepository('ProductosBundle:Producto')->find($id);
        $parameters = $request->request->all();
      
        if(isset($parameters['archivo'])){ 
            $registro = new Galeria();
            $registro->setArchivo($parameters['archivo']);
            $registro->setIsActive($parameters['isActive']);
            $registro->setPosition($parameters['position']);
            $registro->setTipoArchivo($parameters['tipoArchivo']);
            $em->persist($registro);
            $producto->getGalerias()->add($registro);
            $em->flush();  
        }
        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData($parameters);
        return $response;
    }
    
    /**
     * Deletes una Galeria entity de una Producto.
     *
     * @Route("/{id}/galerias/{idGaleria}", name="productos_galerias_delete")
     * @Method("DELETE")
     */
    public function deleteGaleriaAction(Request $request, $id, $idGaleria)
    {
            $em = $this->getDoctrine()->getManager();
            $producto = $em->getRepository('ProductosBundle:Producto')->find($id);
            $galeria = $em->getRepository('GaleriasBundle:Galeria')->find(intval($idGaleria));

            if (!$producto) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }
            
            $producto->getGalerias()->removeElement($galeria);
            $em->remove($galeria);
            $em->flush();
        

        $response = new \Symfony\Component\HttpFoundation\JsonResponse();
        $response->setData(array("ok"=>true));
        return $response;
    }

    /*
     * Crea el thumbnail especifico para la producto de clientes
     * 
     * @return void
     */
    public function crearThumbnailClientes(Galeria $galeria,$width=123,$height=123,$path=""){
        $imagine    = new \Imagine\Gd\Imagine();
        $collage    = $imagine->create(new \Imagine\Image\Box(123, 123));
        $mode       = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $image      = $imagine->open($galeria->getAbsolutePath());
        $sizeImage  = $image->getSize();
        if(strlen($path)==0){
            $path = $galeria->getAbosluteThumbnailPath();
        }
        if($height == null){
            $height = $sizeImage->getHeight();
            if($height>123){
                $height = 123;
            }
        }
        if($width == null){
            $width = $sizeImage->getWidth();
            if($width>123){
                $width = 123;
            }
        }
        $size   =new \Imagine\Image\Box($width,$height);
        $image->thumbnail($size,$mode)->save($path);
        $image = $imagine->open($path);
        $size = $image->getSize();
        if((123 - $size->getWidth())>1){
            $width = ceil((123 - $size->getWidth())/2);
        }else{
            $width = 0;
        }
        if((123 - $size->getHeight())>1){
            $height = ceil((123 - $size->getHeight())/2);
        }else{
            $height =0;
        }    
        $centrado = new \Imagine\Image\Point($width, $height);
        $collage->paste($image,$centrado);
        $collage->save($path);        
    }
    
    private function setNombreSluggable(Producto $entity, $isNew = false){
        $em = $this->getDoctrine()->getManager();
        $entity->setSlugAtValue();
        $slug = $entity->getSlug();
        $id = 0;
        if(!$isNew){ $id = $entity->getId(); }
        $resultados = $em->getRepository('ProductosBundle:Producto')
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
