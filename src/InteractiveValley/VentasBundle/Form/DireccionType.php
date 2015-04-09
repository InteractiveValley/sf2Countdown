<?php

namespace InteractiveValley\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use InteractiveValley\VentasBundle\Entity\Direccion;

class DireccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('calle','text',array('attr'=>array('class'=>'form-control')))
            ->add('numExterior','text',array('attr'=>array('class'=>'form-control')))
            ->add('numInterior','text',array('attr'=>array('class'=>'form-control')))
            ->add('cp','text',array('attr'=>array('class'=>'form-control')))
            ->add('colonia','text',array('attr'=>array('class'=>'form-control')))
            ->add('municipio','text',array('label'=>'Delegacion/Municipio','attr'=>array('class'=>'form-control')))
            ->add('estado','text',array('attr'=>array('class'=>'form-control')))
            ->add('telefono','text',array('attr'=>array('class'=>'form-control')))
            ->add('observaciones',null,array('attr'=>array('class'=>'form-control')))
            ->add('usuario','entity',array(
                'class'=> 'BackendBundle:Usuario',
                'label'=>'Usuario',
                'required'=>true,
                'property'=>'nombre',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Usuario',
                    'data-bind'=>'value: usuario',
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
