<?php

namespace InteractiveValley\ProductosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use InteractiveValley\ProductosBundle\Entity\Producto;
use InteractiveValley\ProductosBundle\Form\DataTransformer\ModeloToNumberTransformer;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
	$modeloTransformer = new ModeloToNumberTransformer($em);
        
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
            ->add('position','hidden')
            ->add($builder->create('modelo','hidden')->addModelTransformer($modeloTransformer))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InteractiveValley\ProductosBundle\Entity\Producto'
        ))
        ->setRequired(array('em'))
	->setAllowedTypes(array('em'=>'Doctrine\Common\Persistence\ObjectManager'))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'interactivevalley_productosbundle_producto';
    }
}
