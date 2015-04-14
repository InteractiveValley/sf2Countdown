<?php

namespace InteractiveValley\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function getFilters() {
        return $this->get('session')->get('filters', array());
    }
    
    protected function setFilters($filtros) {
        $this->get('session')->set('filters', $filtros);
    }
    
    protected function getUsuarioActual() {
        $em = $this->getDoctrine()->getManager();
        $filters = $this->getFilters();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $usuarioId = $filters['usuario'];
            $usuario = $em->getRepository('BackendBundle:Usuario')->find($usuarioId);
            return $usuario;
        } else {
            return $this->getUser();
        }
    }

    public function getNombreMes($month) {
        switch ($month) {
            case 1: return "Enero";
            case 2: return "Febrero";
            case 3: return "Marzo";
            case 4: return "Abril";
            case 5: return "Mayo";
            case 6: return "Junio";
            case 7: return "Julio";
            case 8: return "Agosto";
            case 9: return "Septiembre";
            case 10: return "Octubre";
            case 11: return "Noviembre";
            case 12: return "Diciembre";
        }
    }

    protected function setSecurePassword(&$entity) {
        // encoder
        $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
        $passwordCodificado = $encoder->encodePassword(
                    $entity->getPassword(),
                    $entity->getSalt()
        );
        $entity->setPassword($passwordCodificado);
    }
    
    protected function enviarUsuarioCreado($sUsuario, $sPassword, $usuario) {
        $asunto = 'Usuario creado';
        $isNew = true;
        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom($this->container->getParameter('richpolis.emails.to_email'))
                ->setTo($usuario->getEmail())
                ->setBody(
                $this->renderView('FrontendBundle:Default:enviarCorreo.html.twig', 
                        compact('usuario', 'sUsuario', 'sPassword', 'isNew', 'asunto')), 
                'text/html'
                );
        $this->get('mailer')->send($message);
    }
    
    protected function enviarUsuarioUpdate($sUsuario, $sPassword, $usuario) {
        $asunto = 'Usuario actualizado';
        $isNew = false;
        $message = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom($this->container->getParameter('richpolis.emails.to_email'))
                ->setTo($usuario->getEmail())
                ->setBody(
                $this->renderView('FrontendBundle:Default:enviarCorreo.html.twig', 
                        compact('usuario', 'sUsuario', 'sPassword', 'isNew', 'asunto')), 
                'text/html'
        );
        $this->get('mailer')->send($message);
    }
    
    private $claveApartado = null;
    
    protected function getClaveApartado() {
        $this->claveApartado = $this->get('session')->get('claveApartado', null);
        if ($this->claveApartado == null) {
            //$this->claveApartado = $this->get('session')->get('claveApartado', null);
            do {
                $this->claveApartado = sha1(rand(11111, 99999));
                $resultado = $this->getDoctrine()->getRepository('ProductosBundle:Apartado')
                        ->findOneBy(array('clave' => $this->claveApartado));
            } while ($resultado != null);
            $this->get('session')->set('claveApartado', $this->claveApartado);
        }
        return $this->claveApartado;
    }
}