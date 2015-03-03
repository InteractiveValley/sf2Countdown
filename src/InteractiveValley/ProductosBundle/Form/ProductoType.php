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
            ->add('nombre','text',array('attr'=>array('class'=>'form-control')))
            ->add('descripcion',null,array(
                'label'=>'Descripcion',
                'required'=>true,
                'attr'=>array(
                    'class'=>'cleditor tinymce form-control placeholder',
                   'data-theme' => 'advanced',
                    )
                ))
            ->add('marca','text',array('attr'=>array('class'=>'form-control')))
            ->add('modelo','text',array('attr'=>array('class'=>'form-control')))    
            ->add('unidadMedida','text',array('attr'=>array('class'=>'form-control')))
            ->add('existencia','text',array('attr'=>array('class'=>'form-control')))
            ->add('reservado','text',array('attr'=>array('class'=>'form-control')))
            ->add('precio',null,array('label'=>'Precio','attr'=>array('class'=>'form-control')))
            ->add('iva','choice',array(
                'label'=>'IVA',
                'empty_value'=>false,
                'choices'=>Producto::getArrayIva(),
                'preferred_choices'=>Producto::getPreferedIva(),
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'IVA',
                )))
            ->add('color','choice',array(
                'label'=>'Color',
                'empty_value'=>false,
                'choices'=>Producto::getArrayColores(),
                'preferred_choices'=>Producto::getPreferedColor(),
                'attr'=>array(
                    'class'=>'validate[required] form-control placeholder',
                    'placeholder'=>'Color',
                )))
            ->add('slug','hidden')
            ->add('categoria','entity',array(
                'class'=> 'ProductosBundle:Categoria',
                'label'=>'Categoria',
                'required'=>true,
                'property'=>'nombre',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.position', 'ASC');
                },
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Categoria',
                    'data-bind'=>'value: categoria',
                    )
                ))
            ->add('isPromocional',null,array('label'=>'¿Imagen grande?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
                'data-bind'=>'value: isPromocional'
             )))
            ->add('isNew',null,array('label'=>'¿Mostrar seccion "Lo nuevo"?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
                'data-bind'=>'value: isNew'
             )))
            ->add('isActive',null,array('label'=>'¿Activo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Es activo',
                'data-bind'=>'value: isActive'
             )))
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
