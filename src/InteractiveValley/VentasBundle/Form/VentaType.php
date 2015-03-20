<?php

namespace InteractiveValley\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use InteractiveValley\VentasBundle\Form\DataTransformer\PagoToNumberTransformer;

class VentaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
	$pagoTransformer = new PagoToNumberTransformer($em);
        
        $builder
            ->add('usuario',null,array('attr'=>array('class'=>'form-control')))
            ->add('importe',null,array('attr'=>array('class'=>'form-control')))
            ->add('iva',null,array('attr'=>array('class'=>'form-control')))
            ->add('fechaCompra',null,array('attr'=>array('class'=>'form-control')))
            ->add('envio',null,array('attr'=>array('class'=>'form-control')))
            ->add($builder->create('pago','hidden')->addModelTransformer($pagoTransformer))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InteractiveValley\VentasBundle\Entity\Venta'
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
        return 'interactivevalley_ventasbundle_venta';
    }
}
