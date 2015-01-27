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

class DefaultController extends BaseController {

    /**
     * @Route("/inicio", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request) 
    {
        $categorias = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Categoria')->findAll();
        
        return array('categorias'=>$categorias);
    }
    
    /**
     * @Route("/lo/mas/nuevo", name="lo_mas_nuevo")
     * @Template("FrontendBundle:Default:productos.html.twig")
     */
    public function loMasNuevoAction(Request $request) 
    {
        $productos = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Producto')->findAll();
        
        return array('productos'=>$productos);
    }
    
    /**
     * @Route("/recomendaciones", name="recomendaciones")
     * @Template("FrontendBundle:Default:productos.html.twig")
     */
    public function recomendacionesAction(Request $request) 
    {
        $productos = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Producto')->findAll();
        
        return array('productos'=>$productos);
    }
    
    /**
     * @Route("/categorias", name="categorias")
     * @Template("FrontendBundle:Default:categorias.html.twig")
     * @Method({"GET"})
     */
    public function categoriasAction(Request $request) 
    {
        $categorias = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Categoria')->findAll();
        $route = $request->query->get('route','');
        if($route == "categoria_productos"){
            $isShow = true;
        }else{
            $isShow = false;
        }
        
        return array(
            'categorias'=>$categorias,
            'is_show'=>$isShow,
        );
    }
    
    /**
     * @Route("/categorias/{slug}", name="categoria_productos")
     * @Template("FrontendBundle:Default:productos.html.twig")
     * @Method({"GET"})
     */
    public function categoriaProductosAction(Request $request,$slug) 
    {
        $categoria = $this->getDoctrine()
                          ->getRepository('ProductosBundle:Categoria')
                          ->findOneBy(array('slug'=>$slug));
        
        $productos = $categoria->getProductos();
        
        return array(
            'productos'=>$productos,
            'categoria'=>$categoria
            );
    }
    
    /**
     * @Route("/productos/{slug}", name="get_producto")
     * @Template("FrontendBundle:Default:productoDetalle.html.twig")
     * @Method({"GET"})
     */
    public function mostrarProductoAction(Request $request,$slug) 
    {
        $producto = $this->getDoctrine()
                         ->getRepository('ProductosBundle:Producto')
                         ->findOneBy(array('slug'=>$slug));
        
        return array('producto'=>$producto);
    }
    
    /**
     * @Route("/api/categorias", name="api_categorias")
     * @Method({"GET"})
     */
    public function getCategoriasAction(Request $request) 
    {
        $categorias = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Categoria')->findAll();
        
        $arreglo = array();
        foreach($categorias as $categoria){
            $arreglo1['nombre'] = $categoria->getNombre();
            $arreglo1['slug'] = $categoria->getSlug();
            $arreglo1['position'] = $categoria->getPosition();
            $arreglo1['is_active'] = $categoria->getIsActive();
            $arreglo[]=$arreglo1;
        }
        return new JsonResponse($arreglo);
    }
    
    /**
     * @Route("/api/categorias/{id}", name="api_get_categoria")
     * @Method({"GET"})
     */
    public function getCategoriaAction(Request $request,$id) 
    {
        $categoria = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Categoria')->find($id);
        
        return new JsonResponse(array('categoria'=>$categoria));
    }
    
    /**
     * @Route("/api/productos", name="api_productos")
     * @Method({"GET"})
     */
    public function getProductosAction(Request $request) 
    {
        $categoria = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Categoria')->find($id);
        
        $productos = $categoria->getProductos();
        
        return new JsonResponse(array('productos'=>$productos));
    }
    
    /**
     * @Route("/api/productos/{id}", name="api_get_producto")
     * @Method({"GET"})
     */
    public function getProductoAction(Request $request,$id) 
    {   
        $producto = $this->getDoctrine()
                           ->getRepository('ProductosBundle:Producto')->find($id);
        
        return new JsonResponse(array('producto'=>$producto));
    }

    /**
     * @Route("/contacto", name="frontend_contacto")
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
                $ok = true;
                $error = false;
                $mensaje = "Se ha enviado el mensaje";
                $contacto = new Contacto();
                $form = $this->createForm(new ContactoType(), $contacto);
            } else {
                $ok = false;
                $error = true;
                $mensaje = "El mensaje no se ha podido enviar";
            }
        } else {
            $ok = false;
            $error = false;
            $mensaje = "";
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('FrontendBundle:Default:formContacto.html.twig', array(
                        'form' => $form->createView(),
                        'ok' => $ok,
                        'error' => $error,
                        'mensaje' => $mensaje,
            ));
        }

        $pagina = $em->getRepository('PaginasBundle:Pagina')
                ->findOneBy(array('pagina' => 'contacto'));

        return $this->render('FrontendBundle:Default:contacto.html.twig', array(
                    'form' => $form->createView(),
                    'ok' => $ok,
                    'error' => $error,
                    'mensaje' => $mensaje,
                    'pagina' => $pagina,
        ));
    }

    /**
     * @Route("/recuperar",name="recuperar")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function recuperarAction(Request $request) {
        $sPassword = "";
        $sUsuario = "";
        $msg = "";
        if ($request->isMethod('POST')) {
            $email = $request->get('email');
            $usuario = $this->getDoctrine()->getRepository('BackendBundle:Usuario')
                        ->findOneBy(array('email' => $email));
            if (!$usuario) {
                $this->get('session')->getFlashBag()->add(
                        'error', 'El email no esta registrado.'
                );
                return $this->redirect($this->generateUrl('recuperar'));
            } else {
                $sPassword = substr(md5(time()), 0, 7);
                $sUsuario = $usuario->getUsername();
                $encoder = $this->get('security.encoder_factory')
                        ->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword(
                        $sPassword, $usuario->getSalt()
                );
                $usuario->setPassword($passwordCodificado);
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add(
                        'notice', 'Se ha enviado un correo con la nueva contraseña.'
                );

                $this->enviarRecuperar($sUsuario, $sPassword, $usuario);
                return $this->redirect($this->generateUrl('login'));
            }
        }
        return array('msg' => $msg);
    }

    /**
     * @Route("/registro",name="registro")
     * @Template()
     * @Method({"GET","POST"})
     */
    public function registroAction(Request $request) {
        $usuario = new Usuario();
        $form = $this->createForm(new UsuarioFrontendType(), $usuario);
        $isNew = true;
        if ($request->isMethod('POST')) {
            $parametros = $request->request->all();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $this->setSecurePassword($usuario);
                $rolUsuario = $em->getRepository('UsuariosBundle:Roles')
                        ->findOneBy(array('nombre' => 'ROLE_USUARIO'));
                $usuario->addRol($rolUsuario);
                $em->persist($usuario);
                $em->flush();
                return $this->redirect($this->generateUrl('login'));
            }
        }

        return array(
            'form' => $form->createView(),
            'titulo' => 'Registro',
            'usuario' => $usuario,
            'isNew' => true,
        );
    }

    /**
     * @Route("/perfil",name="perfil_usuario")
     * @Template("FrontendBundle:Default:registro.html.twig")
     * @Method({"GET","POST"})
     */
    public function perfilUsuarioAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();
        if (!$usuario) {
            return $this->redirect($this->generateUrl('login'));
        }
        $form = $this->createForm(new UsuarioFrontendType(), $usuario, array(
            'em' => $this->getDoctrine()->getManager())
        );
        $isNew = false;
        if ($request->isMethod('POST')) {
            //obtiene la contraseña
            $current_pass = $usuario->getPassword();
            $form->handleRequest($request);
            if ($form->isValid()) {
                if (null == $usuario->getPassword()) {
                    // usuario no cambio contraseña
                    $usuario->setPassword($current_pass);
                } else {
                    // se actualiza la contraseña
                    $this->setSecurePassword($usuario);
                }
                $em->flush();
                $this->enviarUsuarioUpdate($usuario->getEmail(), $current_pass, $usuario);
                $this->get('session')->getFlashBag()->add(
                        'notice', 'Se han realizado los cambios solicitados.'
                );
            }
        }

        return array(
            'form' => $form->createView(),
            'usuario' => $usuario,
            'titulo' => 'Editar perfil',
            'isNew' => $isNew,
        );
    }

    private function enviarRecuperar($sUsuario, $sPassword, Usuario $usuario, $isNew = false) {
        $asunto = 'Se ha reestablecido su contraseña';
        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom('noreply@mosaicors.com')
                ->setTo($usuario->getEmail())
                ->setBody(
                $this->renderView('FrontendBundle:Default:enviarCorreo.html.twig', compact('usuario', 'sUsuario', 'sPassword', 'isNew', 'asunto')), 'text/html'
        );
        $this->get('mailer')->send($message);
    }

}
