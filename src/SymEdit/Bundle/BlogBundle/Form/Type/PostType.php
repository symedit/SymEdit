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

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    protected $categoryClass;

    public function __construct($categoryClass)
    {
        $this->categoryClass = $categoryClass;
    }

    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'symedit.form.post.title',
            ))
            ->add('author', 'symedit_user_choose', array(
                'admin' => true,
                'choice_label' => 'profile.fullname',
                'label' => 'symedit.form.post.author',
            ))
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    PostInterface::DRAFT => 'symedit.form.post.status.choices.draft',
                    PostInterface::PUBLISHED => 'symedit.form.post.status.choices.published',
                    PostInterface::SCHEDULED => 'symedit.form.post.status.choices.scheduled',
                ),
                'label' => 'symedit.form.post.status.label',
            ))
            ->add('publishedAt', DateTimeType::class, array(
                'label' => 'symedit.form.post.published_at.label',
                'help_block' => 'symedit.form.post.published_at.help',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => array(
                    'class' => 'datetimepicker',
                ),
            ))
            ->add('categories', 'entity', array(
                'choice_label' => 'title',
                'class' => $this->categoryClass,
                'multiple' => true,
                'expanded' => true,
                'label' => 'symedit.form.post.categories',
            ))
        ;
    }

    public function buildSummaryForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', TextareaType::class, array(
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

    public function buildContentForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array(
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
