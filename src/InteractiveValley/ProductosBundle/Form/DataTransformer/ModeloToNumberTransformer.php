<?php

namespace InteractiveValley\ProductosBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use InteractiveValley\ProductosBundle\Entity\Modelo;

class ModeloToNumberTransformer implements DataTransformerInterface {

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($modelo) {
        if (null === $modelo) {
            return "";
        }
        return $modelo->getId();
    }

    /**
     * Transforms a string (number) to an object (comentario).
     *
     * @param  string $number
     *
     * @return Comentario|null
     *
     * @throws TransformationFailedException if object (comentario) is not found.
     */
    public function reverseTransform($number) {
        if (!$number) {
            return null;
        }
        $modelo = $this->om
                ->getRepository('ProductosBundle:Modelo')
                ->find($number);
        ;
        if (null === $modelo) {
            throw new TransformationFailedException(sprintf(
                    'An Modelo with id "%s" does not exist!', $number
            ));
        }
        return $modelo;
    }

}
