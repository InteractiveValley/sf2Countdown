<?php

namespace LPC\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DetVentaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad')
            ->add('precio')
            ->add('iva')
            ->add('importeIva')
            ->add('importe')
            ->add('venta')
            ->add('producto')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LPC\VentasBundle\Entity\DetVenta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lpc_ventasbundle_detventa';
    }
}
