<?php

namespace InteractiveValley\BackendBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use InteractiveValley\ProductosBundle\Entity\Categoria;

/**
 * Fixtures de la entidad Usuario.
 */
class Categorias extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 20;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $categoria1 = new Categoria();
        $categoria1->setNombre('Categoria 1');
        $manager->persist($categoria1);
        
        $categoria2 = new Categoria();
        $categoria2->setNombre('Categoria 2');
        $manager->persist($categoria2);
        
        $categoria3 = new Categoria();
        $categoria3->setNombre('Categoria 3');
        $manager->persist($categoria3);

        $manager->flush();
    }

    
}