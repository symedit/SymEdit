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

class PostType extends BasePostType
{
    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildBasicForm($builder, $options);

        $builder
            ->add('image', 'symedit_image', array(
                'require_name' => false,
                'required' => false,
                'show_image' => true,
                'allow_remove' => true,
                'label' => 'Featured Image',
            ))
        ;
    }

    protected function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', 'symedit_seo', array(
                'horizontal_label_offset_class' => '',
            ))
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Build basic tab
        $basic = $builder->create('basic', 'tab', array(
            'inherit_data' => true,
            'label' => 'symedit.form.post.tab.basic',
            'icon' => 'info-sign',
        ));

        $this->buildBasicForm($basic, $options);

        // Build SEO tab
        $seo = $builder->create('seo', 'tab', array(
            'inherit_data' => true,
            'label' => 'SEO',
            'icon' => 'search',
        ));

        $this->buildSeoForm($seo, $options);

        // Build summary tab
        $summary = $builder->create('summary', 'tab', array(
            'inherit_data' => true,
            'label' => 'symedit.form.post.tab.summary',
            'horizontal' => false,
            'icon' => 'file',
            'attr' => array(
                'class' => 'full',
            ),
        ));

        $this->buildSummaryForm($summary, $options);

        // Build content tab
        $content = $builder->create('content', 'tab', array(
            'inherit_data' => true,
            'label' => 'symedit.form.post.tab.content',
            'icon' => 'file',
            'horizontal' => false,
            'attr' => array(
                'class' => 'full',
            ),
        ));

        $this->buildContentForm($content, $options);

        // Add all tabs
        $builder
            ->add($basic)
            ->add($summary)
            ->add($content)
        ;
    }
}
