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
     * @Route("/lo/mas/nuevo", name="lo_mas_nuevo")
     * @Template("FrontendBundle:Default:productos.html.twig")
     */
    public function loMasNuevoAction(Request $request) {
        $productos = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Producto')->findBy(array(
            'isNew' => true
        ));
        $categoria = array('id' => 0, 'nombre' => 'Lo nuevo');
        return array(
            'productos' => $productos,
            'categoria' => $categoria
        );
    }

    /**
     * @Route("/recomendaciones", name="recomendaciones")
     * @Template("FrontendBundle:Default:productos.html.twig")
     */
    public function recomendacionesAction(Request $request) {
        $productos = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Producto')->findAll();

        return array('productos' => $productos);
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
        $route = $request->query->get('route', '');
        if ($route == "categoria_productos") {
            $isShow = true;
        } else {
            $isShow = false;
        }
        return array(
            'categorias' => $categorias,
            'is_show' => $isShow,
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
