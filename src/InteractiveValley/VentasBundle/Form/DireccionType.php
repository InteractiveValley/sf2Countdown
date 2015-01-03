<?php

namespace InteractiveValley\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DireccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoDireccion')
            ->add('calle')
            ->add('numExterior')
            ->add('numInterior')
            ->add('cp')
            ->add('municipio')
            ->add('colonia')
            ->add('estado')
            ->add('contacto')
            ->add('paqueteria')
            ->add('fechaAlta')
            ->add('fechaModificacion')
            ->add('usuario')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InteractiveValley\VentasBundle\Entity\Direccion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'interactivevalley_ventasbundle_direccion';
    }
}
