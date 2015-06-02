<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'symedit.form.seo.title',
                'attr' => array('class' => 'span6', 'data-toggle' => 'char-count', 'data-max' => 65),
                'required' => false,
            ))
            ->add('description', 'textarea', array(
                'label' => 'symedit.form.seo.description',
                'attr' => array('class' => 'span6', 'data-toggle' => 'char-count', 'data-max' => 155),
                'required' => false,
            ))
            ->add('keywords', 'textarea', array(
                'label' => 'symedit.form.seo.keywords',
                'attr' => array('class' => 'span6'),
                'required' => false,
            ))
            ->add('index', 'choice', array(
                'choices' => array(
                    true => 'Index',
                    false => 'No Index',
                ),
                'label' => 'symedit.form.seo.index',
            ))
            ->add('follow', 'choice', array(
                'choices' => array(
                    true => 'Follow',
                    false => 'No Follow',
                ),
                'label' => 'symedit.form.seo.follow',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label_render' => false,
        ));
    }

    public function getName()
    {
        return 'symedit_seo';
    }
}
