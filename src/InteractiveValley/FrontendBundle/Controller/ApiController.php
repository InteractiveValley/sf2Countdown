<?php

namespace InteractiveValley\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use InteractiveValley\BackendBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use InteractiveValley\FrontendBundle\Entity\Contacto;
use InteractiveValley\FrontendBundle\Form\ContactoType;
use InteractiveValley\ProductosBundle\Entity\Categoria;
use InteractiveValley\ProductosBundle\Entity\Producto;
use InteractiveValley\ProductosBundle\Entity\Apartado;

class ApiController extends BaseController {
    
    private $claveApartado = null;
    
    protected function getClaveApartado(){
        $this->claveApartado = $this->get('session')->get('claveApartado', null);
        if($this->claveApartado == null){
            //$this->claveApartado = $this->get('session')->get('claveApartado', null);
            do{
                $this->claveApartado = sha1(rand(11111, 99999));
                $resultado = $this->getDoctrine()->getRepository('ProductosBundle:Apartado')
                                                 ->findOneBy(array('clave'=>$this->claveApartado));
            }while($resultado!=null);
            $this->get('session')->set('claveApartado', $this->claveApartado);
        }
        return $this->claveApartado;
    }
    
    /*
    protected function getFilters() {
        return $this->get('session')->get('filters', array());
    }
    
    protected function setFilters($filtros) {
        $this->get('session')->set('filters', $filtros);
    }
    */
    
    /**
     * @Route("/api/categorias", name="api_get_categorias")
     * @Method({"GET"})
     */
    public function getCategoriasAction(Request $request) {
        $categorias = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Categoria')->findAll();

        $arreglo = array();
        foreach ($categorias as $categoria) {
            $arregloCat = $this->getArrayCategoria($categoria);
            $arreglo[] = $arregloCat;
        }
        return new JsonResponse($arreglo);
    }

    private function getArrayCategoria(Categoria $categoria) {
        $arreglo = array();
        $arreglo['nombre'] = $categoria->getNombre();
        $arreglo['slug'] = $categoria->getSlug();
        $arreglo['position'] = $categoria->getPosition();
        $arreglo['isActive'] = $categoria->getIsActive();
        return $arreglo;
    }

    /**
     * @todo Obligatorio enviar un parametro de categorias 
     * @Route("/api/productos", name="api_get_productos")
     * @Method({"GET"})
     */
    public function getProductosAction(Request $request) {
        if ($request->query->has('categoria')) {
            $idCategoria = $request->query->get('categoria');
			
            if ($idCategoria == "lo-nuevo") {
                $productos = $this->getDoctrine()
                                  ->getRepository('ProductosBundle:Producto')->findBy(array(
                                    'isNew' => true
                                  ));
            } else {
                $categoria = $this->getDoctrine()
                                  ->getRepository('ProductosBundle:Categoria')
                                  ->findOneBy(array('slug'=>$idCategoria));
                if(!$categoria){
                    $productos = array();
                }else{
                    $productos = $categoria->getProductos();
                }
            }
        } else {
            $productos = $this->getDoctrine()
                            ->getRepository('ProductosBundle:Producto')->findAll();
        }
        $aProductos = array();
        $imagine = $this->container->get('liip_imagine.cache.manager');
        foreach ($productos as $producto) {
            $aProductos[] = $this->getArrayProducto($producto, $imagine);
        }

        return new JsonResponse($aProductos);
    }
    
    /**
     * @todo Obligatorio enviar un parametro de categorias 
     * @Route("/api/carrito/productos", name="api_get_productos_carrito")
     * @Method({"GET"})
     */
    public function getProductosCarritoAction(Request $request) {
        $clave = $this->getClaveApartado();
        $apartados = $this->getDoctrine()
                          ->getRepository('ProductosBundle:Apartado')->findBy(array(
                              'clave'=> $clave
                          ));
        $aProductos = array();
        $imagine = $this->container->get('liip_imagine.cache.manager');
        foreach ($apartados as $apartado) {
            $aProductos[] = $this->getArrayApartado($apartado, $imagine);
        }
        return new JsonResponse($aProductos);
    }
    
    private function getArrayApartado($apartado, $imagine = null) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        $arreglo = $this->getArrayProducto($apartado->getProducto(), $imagine);
        $arreglo['minutos'] = 25;
        $arreglo['cantidad'] = $apartado->getCantidad();
        return $arreglo;
    }

    private function getArrayProducto($producto, $imagine = null) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        $arreglo['id'] = $producto->getId();
        $arreglo['nombre'] = $producto->getNombre();
        $arreglo['slug'] = $producto->getSlug();
        $arreglo['existencia'] = $producto->getExistencia();
        $arreglo['reservado'] = $producto->getReservado();
        $arreglo['precio'] = $producto->getPrecio();
        $arreglo['iva'] = $producto->getIva();
        $arreglo['isPromocional'] = $producto->getIsPromocional();
        $arreglo['isNew'] = $producto->getIsNew();
        $arreglo['isActive'] = $producto->getIsActive();
        if ($producto->getIsPromocional()) {
            $filtro = "imagen_grande";
        } else {
            $filtro = "imagen_chica";
        }
        $arreglo['imagen'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), $filtro);
        $arreglo['thumbnail'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), 'imagen_carrito');
        $arreglo['galerias'] = $this->getArrayGalerias($producto->getGalerias(), $imagine);
        $arreglo['categoria'] = $this->getArrayCategoria($producto->getCategoria());
        return $arreglo;
    }

    private function getArrayGalerias($galerias, $imagine = null) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        $cont = 0;
        foreach ($galerias as $galeria) {
            $arreglo[$cont] = array(
                'imagen' => $imagine->getBrowserPath($galeria->getWebPath(), 'imagen_carrusel'),
                'thumbnail' => $imagine->getBrowserPath($galeria->getWebPath(), 'imagen_carrusel_thumbnail'),
            );
            $cont++;
        }
        return $arreglo;
    }

    /**
     * @Route("/api/productos/{slug}", name="api_get_producto")
     * @Method({"GET"})
     */
    public function getProductoAction(Request $request, $slug) {
        $producto = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Producto')->findOneBy(array('slug' => $slug));

        return new JsonResponse($this->getArrayProducto($producto));
    }

    /**
     * @Route("/api/contacto", name="frontend_contacto")
     * @Method({"GET", "POST"})
     */
    public function contactoAction(Request $request) {
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $datos = $form->getData();
                $configuracion = $em->getRepository('BackendBundle:Configuraciones')
                        ->findOneBy(array('slug' => 'email-contacto'));
                $message = \Swift_Message::newInstance()
                        ->setSubject('Contacto desde pagina')
                        ->setFrom($datos->getEmail())
                        ->setTo($configuracion->getTexto())
                        ->setBody($this->renderView('FrontendBundle:Default:contactoEmail.html.twig', array('datos' => $datos)), 'text/html');
                $this->get('mailer')->send($message);
                // Redirige - Esto es importante para prevenir que el usuario
                // reenvíe el formulario si actualiza la página
                $status = 'send';
                $mensaje = "Se ha enviado el mensaje";
                $contacto = new Contacto();
                $form = $this->createForm(new ContactoType(), $contacto);
            } else {
                $status = 'notsend';
                $mensaje = "El mensaje no se ha podido enviar";
            }
        } else {
            $status = 'new';
            $mensaje = "";
        }

        if ($request->isXmlHttpRequest()) {
            $vista = $this->renderView('FrontendBundle:Default:formContacto.html.twig', array(
                'form' => $form->createView(),
                'status' => $status,
                'mensaje' => $mensaje,
            ));
            return new JsonResponse(array(
                'form' => $vista,
                'status' => $status,
                'mensaje' => $mensaje,
            ));
        }

        return $this->render('FrontendBundle:Default:formContacto.html.twig', array(
                    'form' => $form->createView(),
                    'status' => $status,
                    'mensaje' => $mensaje
        ));
    }

    /**
     * @Route("/api/existe/email",name="existe_email")
     * @Template()
     * @Method({"POST"})
     */
    public function existeAction(Request $request) {
        if ($request->isMethod('POST')) {
            $email = $request->get('email');
            $usuario = $this->getDoctrine()->getRepository('BackendBundle:Usuario')
                    ->findOneBy(array('email' => $email));
            if (!$usuario) {
                return new JsonResponse(array('existe' => false));
            } else {
                return new JsonResponse(array('existe' => true));
            }
        }
        return new JsonResponse(array('existe' => null));
    }

    /**
     * @Route("/api/carrito/add/{slug}",name="carrito_add")
     * @Method({"POST"})
     */
    public function carritoAddAction(Request $request,$slug) {
        if ($request->isMethod('POST')) {
            $cantidad = $request->request->get('cantidad', 1);
            $producto = $this->getDoctrine()->getRepository('ProductosBundle:Producto')
                    ->findOneBy(array('slug' => $slug));
            if (!$producto) {
                return new JsonResponse(array('status' => 'no_existe'));
            } else {
                if ($producto->getExistencia() > 0) {
                    if ($producto->getExistencia() > $cantidad) {
                        $this->addProductoCarrito($producto,$cantidad);
                        return new JsonResponse(array('status' => 'apartado'));
                    } else {
                        return new JsonResponse(array(
                            'status' => 'no_existencia_solicitada',
                            'menssage' => 'Existencia actual: ' . $producto->getExistencia() . ', Apartado actual: ' . $producto->getApartado()
                        ));
                    }
                } else {
                    return new JsonResponse(array('status' => 'no_existencia'));
                }
            }
        }
        return new JsonResponse(array('status' => 'no_post'));
    }
    
    private function addProductoCarrito(Producto $producto, $cantidad){
        $clave = $this->getClaveApartado();
        $producto->setExistencia($producto->getExistencia()-$cantidad);
        $producto->setReservado($producto->getReservado()+$cantidad);
        $apartado = new Apartado();
        $apartado->setClave($clave);
        $apartado->setCantidad($cantidad);
        $apartado->setProducto($producto);
        $em = $this->getDoctrine()->getManager();
        $em->persist($producto);
        $em->persist($apartado);
        $em->flush();
    }
    
    /**
     * @Route("/api/revisar/apartados", name="api_get_revisar_apartados")
     * @Method({"GET"})
     */
    public function revisarApartadosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $apartados = $em->getRepository('ProductosBundle:Apartado')->findAll();
        $cont = 0;
        foreach($apartados as $apartado){
            $fecha1 = $apartado->getCreatedAt();
            $fecha2 = new \DateTime();
            $intervalo = $fecha1->diff($fecha2);
            $minutos = $intervalo->format("%i"); //minutos de intervalo
            if($minutos > $this->container->getParameter('richpolis.tiempo.permitido')){
                $this->removeProductoCarrito($apartado->getProducto(), $apartado, $em);
                $cont++;
            }
        }
        return new JsonResponse(array('apartados_quitados'=>$cont));
    }
    
    /**
     * @Route("/api/carrito/remove/{slug}",name="carrito_remove")
     * @Method({"POST"})
     */
    public function carritoRemoveAction(Request $request, $slug) {
        if ($request->isMethod('POST')) {
            $producto = $this->getDoctrine()->getRepository('ProductosBundle:Producto')
                             ->findOneBy(array('slug' => $slug));
            $clave = $this->getClaveApartado();
            $apartado = $this->getDoctrine()->getRepository('ProductosBundle:Apartado')
                             ->findOneBy(array('clave'=>$clave,'producto'=>$producto));
            if (!$apartado) {
                return new JsonResponse(array('status' => 'no_existe_apartado'));
            } else {
                $em = $this->getDoctrine()->getManager();
                $this->removeProductoCarrito($producto, $apartado, $em);
                return new JsonResponse(array('status' => 'apartado_removido'));
            }
        }
        return new JsonResponse(array('status' => 'no_post'));
    }
    
    protected function removeProductoCarrito(Producto $producto, $apartado, &$em = null){
        if(!$em){
            $em = $this->getDoctrine()->getManager();
        }
        $producto->setExistencia($producto->getExistencia()+$apartado->getCantidad());
        $producto->setReservado($producto->getReservado()-$apartado->getCantidad());
        $em->persist($producto);
        $em->remove($apartado);
        $em->flush();
    }
    
    /**
     * @Route("/api/carrito/update/{slug}",name="carrito_update")
     * @Method({"POST"})
     */
    public function carritoUpdateAction(Request $request, $slug) {
        if ($request->isMethod('POST')) {
            $cantidad = $request->request->get('cantidad');
            $producto = $this->getDoctrine()->getRepository('ProductosBundle:Producto')
                             ->findOneBy(array('slug' => $slug));
            $clave = $this->getClaveApartado();
            $apartado = $this->getDoctrine()->getRepository('ProductosBundle:Apartado')
                             ->findOneBy(array('clave'=>$clave,'producto'=>$producto));
            if (!$apartado) {
                return new JsonResponse(array('status' => 'no_existe_apartado'));
            } else {
                // revertimos el apartado
                $producto->setExistencia($producto->getExistencia()+$apartado->getCantidad());
                $producto->setReservado($producto->getReservado()-$apartado->getCantidad());
                // realizamos la actualizacion
                $producto->setExistencia($producto->getExistencia()-$cantidad);
                $producto->setReservado($producto->getReservado()+$cantidad);
                //actualizamos el apartado
                $apartado->setCantidad($cantidad);
                //actualizamos los datos
                $em = $this->getDoctrine()->getManager();
                $em->persist($producto);
                $em->persist($apartado);
                $em->flush();
                return new JsonResponse(array('status' => 'apartado_actualizado'));
            }
        }
        return new JsonResponse(array('status' => 'no_post'));
    }
}
