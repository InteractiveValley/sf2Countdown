<?php

namespace InteractiveValley\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FacturaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rfc','text',array('attr'=>array('class'=>'form-control'), 'label'=>'RFC'))
            ->add('razonSocial','text',array('attr'=>array('class'=>'form-control'), 'label'=>'Razon social'))
            ->add('calle','text',array('attr'=>array('class'=>'form-control'), 'label'=>'Direccion'))
            ->add('numExterior','text',array('attr'=>array('class'=>'form-control'), 'label'=>'Num. Exterior'))
            ->add('numInterior','text',array('attr'=>array('class'=>'form-control'), 'label'=>'Num. Interior'))
            ->add('cp','text',array('attr'=>array('class'=>'form-control'), 'label'=>'Codigo postal'))
            ->add('colonia','text',array('attr'=>array('class'=>'form-control'), 'label'=>'Colonia'))
            ->add('municipio','text',array('label'=>'Delegacion/Municipio','attr'=>array('class'=>'form-control')))
            ->add('ciudad','text',array('attr'=>array('class'=>'form-control'),'label'=>'Cuidad'))
            ->add('estado','text',array('attr'=>array('class'=>'form-control'),'label'=>'Estado'))
            ->add('emailEnvio','text',array('attr'=>array('class'=>'form-control'),'label'=>'Email envio'))
            ->add('contacto','text',array('attr'=>array('class'=>'form-control'),'label'=>'Contacto'))            
            ->add('telefonoContacto','text',array('attr'=>array('class'=>'form-control'),'label'=>'Telefono / Celular'))
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
            'data_class' => 'InteractiveValley\VentasBundle\Entity\Factura'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'interactivevalley_ventasbundle_factura';
    }
}
