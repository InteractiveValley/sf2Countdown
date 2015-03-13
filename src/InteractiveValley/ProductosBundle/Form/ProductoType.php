<?php

namespace InteractiveValley\ProductosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use InteractiveValley\ProductosBundle\Entity\Producto;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inventario','text',array('attr'=>array('class'=>'form-control')))
            ->add('color','choice',array(
                'label'=>'Color',
                'empty_value'=>false,
                'choices'=>Producto::getArrayColores(),
                'preferred_choices'=>Producto::getPreferedColor(),
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'Color',
                )))
            ->add('modelo','entity',array(
                'class'=> 'ProductosBundle:Modelo',
                'label'=>'Modelo',
                'required'=>true,
                'property'=>'nombre',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.position', 'ASC');
                },
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Modelo',
                    'data-bind'=>'value: modelo',
                    )
                ))
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
