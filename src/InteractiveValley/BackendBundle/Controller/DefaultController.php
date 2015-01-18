<?php

namespace InteractiveValley\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/backend", name="backend_homepage")
     * @Template("BackendBundle:Default:index.html.twig")
     */
    public function backendAction(){
        return array();
    }
    
    /**
     * @Route("/backend/login", name="backend_login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'BackendBundle:Security:login.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
                'ruta'          => 'backend_login_check',
            )
        );
    }
    
    /**
     * @Route("/backend/login_check", name="backend_login_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/backend/logout", name="backend_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
        
    }
}