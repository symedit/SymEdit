<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use SymEdit\Bundle\BlogBundle\Form\Type\PostType as BasePostType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends BasePostType
{
    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildBasicForm($builder, $options);

        $builder
            ->add('image', 'symedit_image_choose', array(
                'required' => false,
                'show_image' => true,
                'label' => 'symedit.form.post.image',
            ))
        ;
    }

    public function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', 'symedit_seo', array(
                'horizontal_label_offset_class' => '',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'tabs_data' => array(
                'basic' => array(
                    'label' => 'symedit.form.post.tab.basic',
                    'icon' => 'info-sign',
                ),
                'seo' => array(
                    'label' => 'SEO',
                    'icon' => 'search',
                ),
                'summary' => array(
                    'label' => 'symedit.form.post.tab.summary',
                    'horizontal' => false,
                    'icon' => 'file',
                    'attr' => array(
                        'class' => 'full',
                    ),
                ),
                'content' => array(
                    'label' => 'symedit.form.post.tab.content',
                    'icon' => 'file',
                    'horizontal' => false,
                    'attr' => array(
                        'class' => 'full',
                    ),
                ),
            ),
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Left blank for tab builder
    }
}
