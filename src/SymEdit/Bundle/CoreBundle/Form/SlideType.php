<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('image', 'symedit_image', array(
                'file_label' => 'Slider Image',
                'name_label' => 'Slider File Name',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SymEdit\Bundle\CoreBundle\Model\Slide'
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_slidetype';
    }
}
