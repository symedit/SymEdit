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
    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
        ;
    }

    protected function buildSummaryForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', 'textarea', array(
                'label_render' => false,
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:300px',
                    'placeholder' => 'Post Summary...',
                ),
                'required' => false,
            ))
        ;
    }

    protected function buildContentForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('content', 'textarea', array(
                'label_render' => false,
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                    'placeholder' => 'Post Content...',
                ),
                'required' => false,
            ))
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildBasicForm($builder, $options);
        $this->buildSummaryForm($builder, $options);
        $this->buildContentForm($builder, $options);
    }

    public function getName()
    {
        return 'symedit_post';
    }
}
