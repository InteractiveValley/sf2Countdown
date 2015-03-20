<?php

namespace InteractiveValley\VentasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use InteractiveValley\VentasBundle\Form\DataTransformer\VentaToNumberTransformer;

class PagoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
	$ventaTransformer = new VentaToNumberTransformer($em);
        
        $builder
            ->add('importe')
            ->add('iva')
            ->add('fechaPago')
            ->add('formaPago')
            ->add($builder->create('venta','hidden')->addModelTransformer($ventaTransformer))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InteractiveValley\VentasBundle\Entity\Pago'
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
        return 'interactivevalley_ventasbundle_pago';
    }
}
