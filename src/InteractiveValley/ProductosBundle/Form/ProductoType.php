<?php

namespace InteractiveValley\ProductosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('marca')
            ->add('unidadMedida')
            ->add('existencia')
            ->add('reservado')
            ->add('precio')
            ->add('iva')
            ->add('fechaAlta')
            ->add('fechaModificacion')
            ->add('status')
            ->add('slug')
            ->add('galerias')
            ->add('categoria')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InteractiveValley\ProductosBundle\Entity\Producto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'interactivevalley_productosbundle_producto';
    }
}
