<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Isometriks\Bundle\SymEditBundle\Model\Image;

class SlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('caption', 'textarea', array(
                'required' => false,
                'attr' => array(
                    'rows' => 5,
                ),
            ))
            ->add('position', 'choice', array(
                'required' => false,
                'choices' => array(
                    '' => 'Bottom',
                    'left' => 'Left',
                    'top' => 'Top',
                    'right' => 'Right',
                )
            ))
            ->add('image', new ImageType(), array(
                'file_label' => 'Slider Image',
                'name_label' => 'Slider File Name',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Model\Slide'
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_slidetype';
    }
}
