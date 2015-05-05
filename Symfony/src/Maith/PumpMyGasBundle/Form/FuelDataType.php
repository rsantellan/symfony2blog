<?php

namespace Maith\PumpMyGasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FuelDataType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fueldate', null, array(
                'widget'=> 'single_text',
                'format' => 'dd-MM-yyyy',
            ))
            ->add('price')
            ->add('fuelquantity')
            ->add('kilometers')
            //->add('kilometerperliter')
            //->add('priceperliter')
            ->add('notes')
            ->add('car')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Maith\PumpMyGasBundle\Entity\FuelData'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'maith_pumpmygasbundle_fueldata';
    }
}
