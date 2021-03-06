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
use InteractiveValley\VentasBundle\Entity\Venta;
use InteractiveValley\VentasBundle\Entity\DetVenta;

class DefaultController extends BaseController {

    /**
     * @Route("/inicio", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request) {
        $categorias = $this->getDoctrine()
                            ->getRepository('ProductosBundle:Categoria')
                            ->findBy(array(),array('position'=>'ASC'));

        return array('categorias' => $categorias);
    }

    /**
     * @Route("/pago/realizado", name="pago_realizado")
     */
    public function pagoRealizadoAction(Request $request) {
        $clave = $this->getClaveApartado();
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $apartados = $em->getRepository('ProductosBundle:Apartado')->findBy(array(
            'clave' => $clave
        ));
        $envio = $em->getRepository('ProductosBundle:Direccion')->findBy(array(
            'usuario' => $usuario
        ));
        $venta = new Venta();
        $venta->setUsuario($usuario);
        $venta->setEnvio($envio);
        $venta->setFechaCompra(new \DateTime());
        $importe = 0.0;
        $em->persist($venta);
        foreach($apartados as $apartado){
            $detVenta = new DetVenta();
            $detVenta->setProducto($apartado->getProducto());
            $detVenta->setCantidad($apartado->getCantidad());
            $detVenta->setPrecio($apartado->getModelo()->getPrecio());
            $detVenta->setIva($apartado->getModelo()->getIva());
            $detVenta->setImporte($detVenta->getCantidad()*$detVenta->getPrecio());
            $importe += $detVenta->getImporte();
            $venta->addDetVenta($detVenta);
            $em->persist($detVenta);
            $em->remove($apartado);
        }
        $em->flush();
        $venta->setImporte($importe);
        $em->flush();
        return $this->redirect($this->generateUrl('homepage'));
    }
    
    /**
     * @Route("/pago/cancelado", name="pago_cancelado")
     */
    public function pagoCanceladoAction(Request $request) {
        return $this->redirect($this->generateUrl('homepage'));
    }
    
    /**
     * @Route("/colores", name="filtro_colores")
     * @Template("FrontendBundle:Default:colores.html.twig")
     * @Method({"GET"})
     */
    public function coloresAction(Request $request) {
        $colores = array(
            array('color'=>'#9F0700','nombre'=>'color-carmesi'),
            array('color'=>'#FA9000','nombre'=>'color-amarillo'),
            array('color'=>'#7F5400','nombre'=>'color-cafe'),
            array('color'=>'#1DA5FF','nombre'=>'color-azul'),
            array('color'=>'#084664','nombre'=>'color-azul-marino'),
            array('color'=>'#3CAE55','nombre'=>'color-verde'),
            array('color'=>'#F500FC','nombre'=>'color-fiusa'),
            array('color'=>'#A0A0A0','nombre'=>'color-gris'),
            array('color'=>'#FFFFFF','nombre'=>'color-blanco'),
        );
        return array(
            'colores' => $colores,
        );
    }

    /**
     * @Route("/categorias", name="menu_categorias")
     * @Template("FrontendBundle:Default:categorias.html.twig")
     * @Method({"GET"})
     */
    public function categoriasAction(Request $request) {
        $categorias = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Categoria')
                        ->findBy(array(),array('position'=>'ASC'));
        return array(
            'categorias' => $categorias
        );
    }
    
    /**
     * @Route("/categorias/{slug}", name="categoria_productos")
     * @Template("FrontendBundle:Default:productos.html.twig")
     * @Method({"GET"})
     */
    public function categoriaProductosAction(Request $request, $slug) {
        $categoria = $this->getDoctrine()
                ->getRepository('ProductosBundle:Categoria')
                ->findOneBy(array('slug' => $slug));

        $productos = $categoria->getProductos();

        return array(
            'productos' => $productos,
            'categoria' => $categoria
        );
    }

    /**
     * @Route("/productos/{slug}", name="get_producto")
     * @Template("FrontendBundle:Default:productoDetalle.html.twig")
     * @Method({"GET"})
     */
    public function mostrarProductoAction(Request $request, $slug) {
        $producto = $this->getDoctrine()
                ->getRepository('ProductosBundle:Producto')
                ->findOneBy(array('slug' => $slug));

        return array('producto' => $producto);
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
        $form = $this->createForm(new UsuarioType(), $usuario);
        $isNew = true;
        if ($request->isMethod('POST')) {
            $parametros = $request->request->all();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $this->setSecurePassword($usuario);
                $em->persist($usuario);
                $em->flush();

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(array('status' => true));
                }

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
                ->setFrom($this->container->get('richpolis.emails.to_email'))
                ->setTo($usuario->getEmail())
                ->setBody(
                $this->renderView('FrontendBundle:Default:enviarCorreo.html.twig', compact('usuario', 'sUsuario', 'sPassword', 'isNew', 'asunto')), 'text/html'
        );
        $this->get('mailer')->send($message);
    }
}
