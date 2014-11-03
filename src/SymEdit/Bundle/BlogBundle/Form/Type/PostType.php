<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use SymEdit\Bundle\BlogBundle\Model\Post;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'inherit_data' => true,
            'label' => 'Basic',
            'icon' => 'info-sign',
        ));

        $basic
            ->add('title', 'text')
            ->add('author', 'symedit_user_choose', array(
                'admin' => true,
                'property' => 'profile.fullname',
            ))
            ->add('status', 'choice', array(
                'choices' => array(
                    Post::DRAFT => 'Draft',
                    Post::PUBLISHED => 'Published',
                ),
            ))
            ->add('categories', 'entity', array(
                'property' => 'title',
                'class'    => 'SymEdit\Bundle\BlogBundle\Model\Category',
                'multiple' => true,
                'expanded'  => true,
            ))
            ->add('image', 'symedit_image', array(
                'require_name' => false,
                'required' => false,
                'show_image' => true,
                'allow_remove' => true,
                'label' => 'Featured Image',
            ));

        $seo = $builder->create('seo', 'tab', array(
            'inherit_data' => true,
            'label' => 'SEO',
            'icon' => 'search',
        ));

        $seo
            ->add('seo', 'symedit_seo', array(
                'horizontal_label_offset_class' => '',
            ));

        $summary = $builder->create('summary', 'tab', array(
            'inherit_data' => true,
            'label' => 'Summary',
            'horizontal' => false,
            'icon' => 'file',
            'attr' => array(
                'class' => 'full',
            ),
        ));

        $summary
            ->add('summary', 'textarea', array(
                'label_render' => false,
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:300px',
                    'placeholder' => 'Post Summary...',
                ),
                'required' => false,
            ));

        $content = $builder->create('content', 'tab', array(
            'inherit_data' => true,
            'label' => 'Content',
            'icon' => 'file',
            'horizontal' => false,
            'attr' => array(
                'class' => 'full',
            ),
        ));

        $content
            ->add('content', 'textarea', array(
                'label_render' => false,
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                    'placeholder' => 'Post Content...',
                ),
                'required' => false,
            ));

        $builder
            ->add($basic)
            ->add($seo)
            ->add($summary)
            ->add($content);
    }

    public function getName()
    {
        return 'symedit_post';
    }
}
