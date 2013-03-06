<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'help_block' => 'Lowercase letters, numbers, hypens or underscores.', 
            ))
            ->add('description', 'textarea')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Entity\Slider'
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_slidertype';
    }
}
