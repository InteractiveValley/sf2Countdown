<?php

namespace InteractiveValley\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
use InteractiveValley\ProductosBundle\Entity\Color;
use InteractiveValley\VentasBundle\Entity\Direccion;
use InteractiveValley\VentasBundle\Entity\Factura;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ApiController extends BaseController {

    private $contModelos = 0;

    /**
     * @Route("/api/usuario/{id}", name="api_get_usuario")
     * @Method({"GET"})
     */
    public function getUsuarioAction(Request $request,$id) {
        return $this->getUsuariosAction($request);
    }
    
    /**
     * @Route("/api/usuario", name="api_get_usuarios")
     * @Method({"GET"})
     */
    public function getUsuariosAction(Request $request) {
        $user = $this->getUser();
        if($user){
            $arreglo = array(
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'repetir' => $user->getPassword(),
                'email' => $user->getEmail(),
                'telefono' => $user->getTelefono(),
                'grupo' => $user->getGrupo(),
                'isActive' => $user->getIsActive()
            );
        }else{
            $arreglo = array();
        }
        return new JsonResponse($arreglo);
    }
    
    /**
     * @Route("/api/usuario", name="api_post_usuario")
     * @Method({"POST"})
     */
    public function postUsuarioAction(Request $request) {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('BackendBundle:Usuario')
                      ->findOneBy(array('email'=>$data['email']));
        if(!$usuario){
            $usuario = new \InteractiveValley\BackendBundle\Entity\Usuario();
        }
        $usuario->setNombre($data['nombre']);
        $usuario->setPassword($data['password']);
        $usuario->setEmail($data['email']);
        $usuario->setTelefono($data['telefono']);
        $usuario->setGrupo(\InteractiveValley\BackendBundle\Entity\Usuario::GRUPO_USUARIOS);
        $usuario->setIsActive($data['isActive']);
        $this->setSecurePassword($usuario);
        $em->persist($usuario);
        $em->flush();
        $response = new JsonResponse(array('id'=>$usuario->getId()), Response::HTTP_CREATED);
        $this->enviarUsuarioCreado($data['email'], $data['password'], $usuario);
        //logear al usuario nuevo
        $this->logearUsuario($usuario);
        return $response;
    }
    
    private function logearUsuario($usuario){
        $providerKey = 'frontend';
        $roles = $usuario->getRoles();
        // Finalmente logueamos al usuario
        $token = new UsernamePasswordToken($usuario, null, $providerKey, $roles);
        $this->container->get('security.context')->setToken($token);
        return true;
    }
    
    /**
     * @Route("/api/usuario/{id}", name="api_put_usuario")
     * @Method({"PUT"})
     */
    public function putUsuarioAction(Request $request, $id) {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('BackendBundle:Usuario')
                      ->find($id);
        if(!$usuario){
            $response = new JsonResponse(null , Response::HTTP_NOT_FOUND);
        }else{
            $usuario->setNombre($data['nombre']);
            $current_pass = $usuario->getPassword();
            $usuario->setEmail($data['email']);
            $usuario->setTelefono($data['telefono']);
            $usuario->setGrupo(\InteractiveValley\BackendBundle\Entity\Usuario::GRUPO_USUARIOS);
            $usuario->setIsActive($data['isActive']);
            if (!isset($data['password'])) {
                // El usuario no cambia su contraseña.
                $usuario->setPassword($current_pass);
                $data['password']="";
            } else {
                $usuario->setPassword($data['password']);
                // actualizamos la contraseña.
                $this->setSecurePassword($usuario);
            }
            $em->persist($usuario);
            $em->flush();
            $response = new JsonResponse(null, Response::HTTP_NO_CONTENT);
            $this->enviarUsuarioUpdate($data['email'], $data['password'], $usuario);
        }
        return $response;
    }
    
    /**
     * @Route("/api/colores", name="api_get_colores")
     * @Method({"GET"})
     */
    public function getColoresAction(Request $request) {
        $colores = $this->getDoctrine()
                ->getRepository('ProductosBundle:Color')
                ->findByActive();

        $arreglo = array();
        foreach ($colores as $color) {
            $arregloCol = $this->getArrayColor($color);
            $arreglo[] = $arregloCol;
        }

        return new JsonResponse($arreglo);
    }
    
    private function getArrayColor(Color $color = null) {
        $arreglo = array();
        if ($color == null)
            return $arreglo;
        $arreglo['id'] = $color->getId();
        $arreglo['nombre'] = $color->getNombre();
        $arreglo['color'] = "#" . $color->getColor();
        $arreglo['texto'] = $color->getColorTexto();
        $arreglo['position'] = $color->getPosition();
        $arreglo['isActive'] = $color->getIsActive();
        return $arreglo;
    }
    
    /**
     * @Route("/api/envio", name="api_get_envio")
     * @Method({"GET"})
     */
    public function getEnvioAction(Request $request) {
        $arreglo = array();
        $user = $this->getUser();
        if($user){    
            $direccion = $this->getDoctrine()
                              ->getRepository('VentasBundle:Direccion')
                              ->findOneBy(array('usuario'=>$user));
            $arreglo = $this->getArrayDireccion($direccion);
        }
        return new JsonResponse($arreglo);
    }

    private function getArrayDireccion(Direccion $direccion = null) {
        $arreglo = array();
        if ($direccion == null)
            return $arreglo;
        $arreglo['id']              =   $direccion->getId();
        $arreglo['calle']           =   $direccion->getCalle();
        $arreglo['numExterior']     =   $direccion->getNumExterior();
        $arreglo['numInterior']     =   $direccion->getNumInterior();
        $arreglo['cp']              =   $direccion->getCp();
        $arreglo['colonia']         =   $direccion->getColonia();
        $arreglo['municipio']       =   $direccion->getMunicipio();
        $arreglo['estado']          =   $direccion->getEstado();
        $arreglo['telefono']        =   $direccion->getTelefono();
        $arreglo['observaciones']   =   $direccion->getObservaciones();
        return $arreglo;
    }
    
    /**
     * @Route("/api/envio", name="api_post_envio")
     * @Method({"POST"})
     */
    public function postEnvioAction(Request $request) {
        return $this->putEnvioAction($request, 0);
    }
    
    /**
     * @Route("/api/envio/{id}", name="api_put_envio")
     * @Method({"PUT"})
     */
    public function putEnvioAction(Request $request,$id) {
        $arreglo = $request->request->all();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if($user){    
            $direccion = $em->getRepository('VentasBundle:Direccion')
                            ->find($id);
            if(!$direccion){
                $direccion = new Direccion();
                $direccion->setUsuario($user);
            }
            $direccion->setCalle($arreglo['calle']);
            $direccion->setNumExterior($arreglo['numExterior']);
            $direccion->setNumInterior($arreglo['numInterior']);
            $direccion->setCp($arreglo['cp']);
            $direccion->setColonia($arreglo['colonia']);
            $direccion->setMunicipio($arreglo['municipio']);
            $direccion->setEstado($arreglo['estado']);
            $direccion->setTelefono($arreglo['telefono']);
            $direccion->setObservaciones($arreglo['observaciones']);
            $em->persist($direccion);
            $em->flush();
            if($id == 0){
                $response = new JsonResponse(array('id'=>$direccion->getId()),  Response::HTTP_CREATED);
            }else{
                $response = new JsonResponse(null, Response::HTTP_NO_CONTENT);
            }
            return $response;
        }
        return new JsonResponse($arreglo);
    }
    
    /**
     * @Route("/api/facturacion", name="api_get_facturacion")
     * @Method({"GET"})
     */
    public function getFacturaAction(Request $request) {
        $arreglo = array();
        $user = $this->getUser();
        if($user){    
            $direccion = $this->getDoctrine()
                              ->getRepository('VentasBundle:Factura')
                              ->findOneBy(array('usuario'=>$user));
            $arreglo = $this->getArrayFacturacion($direccion);
        }
        return new JsonResponse($arreglo);
    }
    
    private function getArrayFacturacion(Factura $direccion = null) {
        // direccion de facturacion
        $arreglo = array();
        if ($direccion == null)
            return $arreglo;
        $arreglo['id']              =   $direccion->getId();
        $arreglo['isFacturar']      =   $direccion->getIsFacturar();
        $arreglo['rfc']             =   $direccion->getRfc();
        $arreglo['razonSocial']     =   $direccion->getRazonSocial();
        $arreglo['calle']           =   $direccion->getCalle();
        $arreglo['numExterior']     =   $direccion->getNumExterior();
        $arreglo['numInterior']     =   $direccion->getNumInterior();
        $arreglo['colonia']         =   $direccion->getColonia();
        $arreglo['cp']              =   $direccion->getCp();
        $arreglo['municipio']       =   $direccion->getMunicipio();
        $arreglo['ciudad']          =   $direccion->getCiudad();
        $arreglo['estado']          =   $direccion->getEstado();
        $arreglo['contacto']        =   $direccion->getContacto();
        $arreglo['telefonoContacto']   =   $direccion->getTelefonoContacto();
        return $arreglo;
    }
    
    /**
     * @Route("/api/facturacion", name="api_post_factura")
     * @Method({"POST"})
     */
    public function postFacturaAction(Request $request) {
        return $this->putFacturaAction($request, 0);
    }
    
    /**
     * @Route("/api/facturacion/{id}", name="api_put_factura")
     * @Method({"PUT"})
     */
    public function putFacturaAction(Request $request,$id) {
        $arreglo = $request->request->all();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        if($user){    
            $direccion = $em->getRepository('VentasBundle:Factura')
                            ->find($id);
            if(!$direccion){
                $direccion = new Factura();
                $direccion->setUsuario($user);
            }
            $direccion->setIsFacturar($arreglo['isFacturar']);
            $direccion->setRfc($arreglo['rfc']);
            $direccion->setRazonSocial($arreglo['razonSocial']);
            $direccion->setCalle($arreglo['calle']);
            $direccion->setNumExterior($arreglo['numExterior']);
            $direccion->setNumInterior($arreglo['numInterior']);
            $direccion->setCp($arreglo['cp']);
            $direccion->setColonia($arreglo['colonia']);
            $direccion->setMunicipio($arreglo['municipio']);
            $direccion->setCiudad($arreglo['ciudad']);
            $direccion->setEstado($arreglo['estado']);
            $direccion->setEmailEnvio($arreglo['emailEnvio']);
            $direccion->setContacto($arreglo['contacto']);
            $direccion->setTelefonoContacto($arreglo['telefonoContacto']);
            $em->persist($direccion);
            $em->flush();
            if($id == 0){
                $response = new JsonResponse(array('id'=>$direccion->getId()),  Response::HTTP_CREATED);
            }else{
                $response = new JsonResponse(null, Response::HTTP_NO_CONTENT);
            }
            return $response;
        }
        return new JsonResponse($arreglo);
    }

    /**
     * @Route("/api/categorias", name="api_get_categorias")
     * @Method({"GET"})
     */
    public function getCategoriasAction(Request $request) {
        $categorias = $this->getDoctrine()
                ->getRepository('ProductosBundle:Categoria')
                ->findByActive();

        $arreglo = array();
        foreach ($categorias as $categoria) {
            $arregloCat = $this->getArrayCategoria($categoria);
            $arreglo[] = $arregloCat;
        }
        return new JsonResponse($arreglo);
    }

    private function getArrayCategorias($categorias) {
        $arreglo = array();
        foreach ($categorias as $categoria) {
            $arreglo[] = $this->getArrayCategoria($categoria);
        }
        return $arreglo;
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
     * @Route("/api/modelos", name="api_get_modelos")
     * @Method({"GET"})
     */
    public function getModelosAction(Request $request) {
        if ($request->query->has('categoria')) {
            $idCategoria = $request->query->get('categoria');

            if ($idCategoria == "lo-nuevo") {
                $modelos = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Modelo')
                        ->modelosLoNuevo();
            } else if ($idCategoria == "promos") {
                $modelos = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Modelo')
                        ->modelosPromos();
            } else {
                $categoria = $this->getDoctrine()
                        ->getRepository('ProductosBundle:Categoria')
                        ->findOneBy(array('slug' => $idCategoria));
                if (!$categoria) {
                    $modelos = array();
                } else {
                    $modelos = $this->getDoctrine()
                            ->getRepository('ProductosBundle:Modelo')
                            ->modelosByCategoria($categoria);
                }
            }
        } else {
            $modelos = $this->getDoctrine()
                    ->getRepository('ProductosBundle:Modelo')
                    ->modelosByCategoria(null);
        }
        $aModelos = array();
        $this->contModelos = 0;
        $imagine = $this->container->get('liip_imagine.cache.manager');
        foreach ($modelos as $modelo) {
            if ($modelo->getInventario() > 0 && $modelo->getIsActive()) {
                $this->contModelos++;
                $aModelos[] = $this->getArrayModelo($modelo, $imagine);
            }
        }

        return new JsonResponse($aModelos);
    }

    private function getArrayModelo($modelo, $imagine = null) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        $arreglo['id'] = $modelo->getId();
        $arreglo['nombre'] = $modelo->getNombre();
        $arreglo['descripcion'] = $modelo->getDescripcion();
        $arreglo['modelo'] = $modelo->getModelo();
        $arreglo['slug'] = $modelo->getSlug();
        $arreglo['inventario'] = $modelo->getInventario();
        $arreglo['precio'] = $modelo->getPrecio();
        $arreglo['iva'] = $modelo->getIva();
        $arreglo['isPromocional'] = $modelo->getIsPromocional();
        $arreglo['isNew'] = $modelo->getIsNew();
        $arreglo['isActive'] = $modelo->getIsActive();
        $filtro = "imagen_chica";
        switch($this->contModelos){
            case 5:
            case 6:
                $filtro = "imagen_grande";
                break;
            case 10:
                $this->contModelos = 0;
                break;
        }
        $arreglo['filtro_imagen'] = $filtro;
        foreach ($modelo->getProductos() as $producto) {
            if (count($producto->getGalerias()) > 0 && $producto->getInventario() > 0) {
                $arreglo['imagen'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), $filtro);
                $arreglo['thumbnail'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), 'imagen_carrito');
                break;
            }
        }
        $arreglo['productos'] = $this->getArrayProductos($modelo->getProductos(), $imagine);
        $arreglo['categorias'] = $this->getArrayCategorias($modelo->getCategorias());
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
                        ->findOneBy(array('slug' => $idCategoria));
                if (!$categoria) {
                    $productos = array();
                } else {
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
     * @todo id obligatorio
     * @Route("/api/carrito/productos/{id}", name="api_get_producto_carrito")
     * @Method({"GET"})
     */
    public function getProductoCarritoAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $clave = $this->getClaveApartado();
        $producto = $em->getRepository('ProductosBundle:Producto')->find($id);
        $apartado = $em->getRepository('ProductosBundle:Apartado')->findOneBy(array(
            'clave' => $clave, 'producto' => $producto,
        ));
        return new JsonResponse($this->getArrayApartado($apartado));
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
            'clave' => $clave
        ));
        $aProductos = array();
        $imagine = $this->container->get('liip_imagine.cache.manager');
        foreach ($apartados as $apartado) {
            $segundos = $this->getSegundosForApartado($apartado);
            if ($segundos > $this->container->getParameter('richpolis.tiempo.permitido')) {
                $this->removeProductoCarrito($apartado->getProducto(), $apartado, $em);
            }else{
                $aProductos[] = $this->getArrayApartado($apartado, $imagine, $segundos);
            }
        }
        return new JsonResponse($aProductos);
    }

    private function getArrayApartado($apartado, $imagine = null, $segundos = null) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        $modelo = $apartado->getProducto()->getModelo();
        $arreglo['modeloId'] = $modelo->getId();
        $arreglo['nombre'] = $modelo->getNombre();
        $arreglo['descripcion'] = $modelo->getDescripcion();
        $arreglo['modelo'] = $modelo->getModelo();
        $arreglo['slug'] = $modelo->getSlug();
        $arreglo['precio'] = $modelo->getPrecio();
        $arreglo['iva'] = $modelo->getIva();
        $arreglo['isPromocional'] = $modelo->getIsPromocional();
        $arreglo['isNew'] = $modelo->getIsNew();
        $arreglo['isActive'] = $modelo->getIsActive();
        $producto = $apartado->getProducto();
        $arreglo['productoId'] = $producto->getId();
        $arreglo['inventario'] = $producto->getInventario();
        $arreglo['color'] = $this->getArrayColor($producto->getColor());
        $arreglo['string_color'] = $producto->getStringColor();
        $filtro = "imagen_carrusel";
        $arreglo['imagen'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), $filtro);
        $arreglo['thumbnail'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), 'imagen_carrito');
        $arreglo['galerias'] = $this->getArrayGalerias($producto->getGalerias(), $imagine);
        $arreglo['cantidad'] = $apartado->getCantidad();
        if($segundos == null){
            $segundos = $this->getSegundosForApartado($apartado);
            if ($segundos > $this->container->getParameter('richpolis.tiempo.permitido')) {
                $arreglo['segundos']=0;
            }else{
                $arreglo['segundos']=$this->container->getParameter('richpolis.tiempo.permitido') - $segundos;
            }
        }else{
            $arreglo['segundos']=$this->container->getParameter('richpolis.tiempo.permitido') - $segundos;
        }
        return $arreglo;
    }

    private function getArrayProductos($productos, $imagine = null, $conModelo = false) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        foreach ($productos as $producto) {
            $arreglo[] = $this->getArrayProducto($producto, $imagine);
        }
        return $arreglo;
    }
    
    private function getSegundosForApartado(&$apartado){
        $fecha1 = $apartado->getCreatedAt();
        $fecha2 = new \DateTime();
        $intervalo = $fecha1->diff($fecha2);
        $dias =     $intervalo->format("%d"); //dias de intervalo
        $horas =    $intervalo->format("%H") + ($dias * 24); //horas de intervalo
        $minutos =  $intervalo->format("%i") + ($horas * 60); //minutos de intervalo
        $segundos = $intervalo->format("%s") + ($minutos * 60);; //segundos de intervalo
        return $segundos;
    }

    private function getArrayProducto($producto, $imagine = null) {
        if (!$imagine) {
            $imagine = $this->container->get('liip_imagine.cache.manager');
        }
        $arreglo = array();
        $arreglo['id'] = $producto->getId();
        $arreglo['inventario'] = $producto->getInventario();
        $arreglo['color'] = $this->getArrayColor($producto->getColor());
        $arreglo['string_color'] = $producto->getStringColor();
        $filtro = "imagen_carrusel";
        $arreglo['imagen'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), $filtro);
        $arreglo['thumbnail'] = $imagine->getBrowserPath($producto->getGalerias()[0]->getWebPath(), 'imagen_carrito');
        $arreglo['galerias'] = $this->getArrayGalerias($producto->getGalerias(), $imagine);
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
     * @Route("/api/modelos/{id}", name="api_get_modelo")
     * @Method({"GET"})
     */
    public function getModeloAction(Request $request, $id) {
        $modelo = $this->getDoctrine()
                ->getRepository('ProductosBundle:Modelo')
                ->find($id);

        return new JsonResponse($this->getArrayModelo($modelo));
    }

    /**
     * @Route("/api/productos/{id}", name="api_get_producto")
     * @Method({"GET"})
     */
    public function getProductoAction(Request $request, $id) {
        $producto = $this->getDoctrine()
                ->getRepository('ProductosBundle:Producto')
                ->find($id);

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
     * @Route("/api/carrito/add/{id}",name="carrito_add")
     * @Method({"POST"})
     */
    public function carritoAddAction(Request $request, $id) {
        if ($request->isMethod('POST')) {
            $cantidad = $request->request->get('cantidad', 1);
            $producto = $this->getDoctrine()->getRepository('ProductosBundle:Producto')
                    ->find($id);
            if (!$producto) {
                return new JsonResponse(array('status' => 'no_existe'));
            } else {
                if ($producto->getInventario() > 0) {
                    if ($producto->getInventario() > $cantidad) {
                        $apartado = $this->addProductoCarrito($producto, $cantidad);
                        return new JsonResponse(array(
                            'status' => 'apartado',
                            'apartado' => $this->getArrayApartado($apartado),
                        ));
                    } else {
                        return new JsonResponse(array(
                            'status' => 'no_existencia_solicitada',
                            'menssage' => 'Inventario actual: ' . $producto->getInventario() . ', Apartado actual: ' . $producto->getApartado()
                        ));
                    }
                } else {
                    return new JsonResponse(array('status' => 'no_existencia'));
                }
            }
        }
        return new JsonResponse(array('status' => 'no_post'));
    }

    private function addProductoCarrito(Producto $producto, $cantidad) {
        $em = $this->getDoctrine()->getManager();
        $clave = $this->getClaveApartado();
        $producto->setInventario($producto->getInventario() - $cantidad);
        $modelo = $producto->getModelo();
        $modelo->setInventario($modelo->getInventario() - $cantidad);
        $apartado = $em->getRepository('ProductosBundle:Apartado')->findOneBy(array(
            'clave' => $clave, 'producto' => $producto
        ));
        if (!$apartado) {
            $apartado = new Apartado();
            $apartado->setClave($clave);
            $apartado->setProducto($producto);
        } else {
            $cantidad += $apartado->getCantidad();
        }
        $apartado->setCantidad($cantidad);
        $apartado->setCreatedAt(new \DateTime());
        $em->persist($producto);
        $em->persist($apartado);
        $em->persist($modelo);
        $em->flush();
        return $apartado;
    }

    /**
     * @Route("/api/revisar/apartados", name="api_get_revisar_apartados")
     * @Method({"GET"})
     */
    public function revisarApartadosAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $apartados = $em->getRepository('ProductosBundle:Apartado')->findAll();
        $cont = 0;
        foreach ($apartados as $apartado) {
            $segundos = $this->getSegundosForApartado($apartado);
            if ($segundos > $this->container->getParameter('richpolis.tiempo.permitido')) {
                $this->removeProductoCarrito($apartado->getProducto(), $apartado, $em);
                $cont++;
            }
        }
        return new JsonResponse(array('apartados_quitados' => $cont));
    }

    /**
     * @Route("/api/carrito/remove/{id}",name="carrito_remove")
     * @Method({"POST"})
     */
    public function carritoRemoveAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $producto = $em->getRepository('ProductosBundle:Producto')->find($id);
            $clave = $this->getClaveApartado();
            $apartado = $em->getRepository('ProductosBundle:Apartado')
                    ->findOneBy(array('clave' => $clave, 'producto' => $producto));
            if (!$apartado) {
                return new JsonResponse(array('status' => 'no_existe_apartado'));
            } else {

                $this->removeProductoCarrito($producto, $apartado, $em);
                return new JsonResponse(array(
                    'status' => 'apartado_removido'
                ));
            }
        }
        return new JsonResponse(array('status' => 'no_post'));
    }

    protected function removeProductoCarrito(Producto $producto, $apartado, &$em = null) {
        if (!$em) {
            $em = $this->getDoctrine()->getManager();
        }
        $modelo = $producto->getModelo();
        $modelo->setInventario($modelo->getInventario() + $apartado->getCantidad());
        $producto->setInventario($producto->getInventario() + $apartado->getCantidad());
        $em->persist($producto);
        $em->remove($apartado);
        $em->persist($modelo);
        $em->flush();
        return true;
    }

    /**
     * @Route("/api/carrito/update/{id}",name="carrito_update")
     * @Method({"POST"})
     */
    public function carritoUpdateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $cantidad = $request->request->get('cantidad');
            $producto = $em->getRepository('ProductosBundle:Producto')->find($id);
            $clave = $this->getClaveApartado();
            $apartado = $em->getRepository('ProductosBundle:Apartado')
                           ->findOneBy(array('clave' => $clave, 'producto' => $producto));
            $diferencia = $cantidad - $apartado->getCantidad();
            if (!$apartado) {
                return new JsonResponse(array('status' => 'no_existe_apartado'));
            } else {
                if($producto->getInventario()>=$diferencia){
                    // quitamos inventario de producto
                    $producto->setInventario($producto->getInventario() - $diferencia);
                    // quitamos inventario del modelo
                    $modelo = $producto->getModelo();
                    $modelo->setInventario($modelo->getInventario() - $diferencia);
                    //actualizamos el apartado
                    $apartado->setCantidad($apartado->getCantidad()+$diferencia);
                    //actualizamos los objetos
                    $apartado->setCreatedAt(new \DateTime());
                    $em->persist($producto);
                    $em->persist($apartado);
                    $em->persist($modelo);
                    $em->flush();
                    return new JsonResponse(array(
                        'status' => 'apartado_actualizado',
                        'apartado' => $this->getArrayApartado($apartado),
                    ));
                }else{
                    return new JsonResponse(array(
                        'status' => 'apartado_no_inventario',
                        'apartado' => $this->getArrayApartado($apartado),
                        'disponible'=>$producto->getInventario()
                    ));
                }
            }
        }
        return new JsonResponse(array('status' => 'no_post'));
    }

}
