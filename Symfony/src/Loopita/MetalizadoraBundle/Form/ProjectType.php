<?php

namespace Loopita\MetalizadoraBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('cliente')
            ->add('tipo_de_trabajo')
            ->add('description')
            ->add('category')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Loopita\MetalizadoraBundle\Entity\Project'
        ));
    }

    public function getName()
    {
        return 'loopita_metalizadorabundle_projecttype';
    }
}
