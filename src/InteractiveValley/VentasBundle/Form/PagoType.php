<?php

namespace InteractiveValley\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PagoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('importe')
            ->add('iva')
            ->add('fechaPago')
            ->add('formaPago')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InteractiveValley\VentasBundle\Entity\Pago'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'interactivevalley_ventasbundle_pago';
    }
}
