<?php

namespace InteractiveValley\VentasBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;


class PagoToNumberTransformer implements DataTransformerInterface {

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
    public function transform($pago) {
        if (null === $pago) {
            return "";
        }
        return $pago->getId();
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
        $pago = $this->om
                ->getRepository('VentasBundle:Pago')
                ->find($number);
        ;
        if (null === $pago) {
            throw new TransformationFailedException(sprintf(
                    'An Pago with id "%s" does not exist!', $number
            ));
        }
        return $pago;
    }

}
