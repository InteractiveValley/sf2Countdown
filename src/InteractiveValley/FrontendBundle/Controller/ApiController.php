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
use InteractiveValley\BackendBundle\Entity\Usuario;
use InteractiveValley\BackendBundle\Form\Frontend\UsuarioType;
use InteractiveValley\ProductosBundle\Entity\Categoria;
use InteractiveValley\GaleriasBundle\Entity\Galeria;

class ApiController extends BaseController {

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
	
	private function getArrayCategoria(Categoria $categoria){
		$arreglo=array();
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
            if ($idCategoria == "lo-mas-nuevo") {
                $productos = $this->getDoctrine()
                                ->getRepository('ProductosBundle:Producto')->findBy(array(
                    'isNew' => true
                ));
            } else {
                $categoria = $this->getDoctrine()
                                ->getRepository('ProductosBundle:Categoria')->find($idCategoria);
                $productos = $categoria->getProductos();
            }
        } else {
            $productos = $this->getDoctrine()
                              ->getRepository('ProductosBundle:Producto')->findAll();
        }
        $aProductos = array();
        $imagine = $this->get('liip_imagine.cache.manager');
        foreach ($productos as $producto) {
            $aProductos[] = $this->getArrayProducto($producto,$imagine);
        }

        return new JsonResponse(array('productos' => $aProductos));
    }
	
	private function getArrayProducto($producto, $imagine = null){
		if(!$imagine){
			$imagine = $this->get('liip_imagine.cache.manager');
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
        if($producto->getIsPromocional()){
        	$filtro = "imagen_grande";
        }else{
            $filtro = "imagen_chica";
        }
        $arreglo['imagen'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), $filtro, true);
        $arreglo['thumbnail'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), 'imagen_carrito', true);
        $arreglo['galerias'] = $this->getArrayGalerias($producto->getGalerias(),$imagine);
        $arreglo['categoria'] = $this->getArrayCategoria($producto->getCategoria());
		return $arreglo;
	}
	
	private function getArrayGalerias($galerias, $imagine = null){
		if(!$imagine){
			$imagine = $this->get('liip_imagine.cache.manager');
		}
		$arreglo = array();
		$cont = 0;
        foreach($galerias as $galeria){
        	$arreglo[$cont] = array(
            	'imagen'=> $imagine->getBrowserPath($producto->getWebPath(), 'imagen_carrusel', true),
                'thumbnail'=> $imagine->getBrowserPath($producto->getWebPath(), 'imagen_carrusel_thumbnail', true),
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
                        ->getRepository('ProductosBundle:Producto')->findOneBy(array('slug'=>$slug));
		
        return new JsonResponse(array(
			'producto' => $this->getArrayProducto($producto),
		));
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

}
