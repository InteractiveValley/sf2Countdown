<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 * 
 * Modificado por Ricardo Alcantara <richpolis@gmail.com>
 *
 */

namespace InteractiveValley\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use InteractiveValley\BackendBundle\Entity\Usuario;

/**
 * Fixtures de la entidad Usuario.
 */
class Usuarios extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 10;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Superadmin
        $admin = new Usuario();
        
        //$admin->setUsername('admin');
        $admin->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $passwordEnClaro = 'admin';
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($admin);
        $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $admin->getSalt());
        $admin->setPassword($passwordCodificado);
        $admin->setNombre("Richpolis Systems");
        $admin->setEmail('richpolis@gmail.com');
        $admin->setTelefono('55555555');
        $admin->setGrupo(Usuario::GRUPO_SUPER_ADMIN);
        $manager->persist($admin);
        
        
        // Superadmin
        $admin = new Usuario();
        
        //$admin->setUsername('admin');
        $admin->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $passwordEnClaro = 'admin';
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($admin);
        $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $admin->getSalt());
        $admin->setPassword($passwordCodificado);
        $admin->setNombre("Administrador general");
        $admin->setEmail('admin@countdown.com');
        $admin->setTelefono('55555555');
        $admin->setGrupo(Usuario::GRUPO_ADMIN);
        $manager->persist($admin);
        
        $usuario = new Usuario();
        
        //$usuario->setUsername('R1_E1A_D101');
        $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $passwordEnClaro = '12345678';
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
        $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $usuario->getSalt());
        $usuario->setPassword($passwordCodificado);
        $usuario->setNombre("Usuario 1");
        $usuario->setEmail('usuario1@countdown.com');
        $usuario->setTelefono('55555555');
        $usuario->setGrupo(Usuario::GRUPO_USUARIOS);
        $manager->persist($usuario);
        
        
        // Usuario 2
        $usuario = new Usuario();
        
        //$usuario->setUsername('R2_E1A_D101');
        $usuario->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $passwordEnClaro = '12345678';
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($usuario);
        $passwordCodificado = $encoder->encodePassword($passwordEnClaro, $usuario->getSalt());
        $usuario->setPassword($passwordCodificado);
        $usuario->setNombre("Usuario 2");
        $usuario->setEmail('usuario2@countdown.com');
        $usuario->setTelefono('55555555');
        $usuario->setGrupo(Usuario::GRUPO_USUARIOS);
        $manager->persist($usuario);

        $manager->flush();
    }

    
}