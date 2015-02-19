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

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Form\EventListener\PageTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    protected $pageRepository;

    public function __construct(RepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'symedit.form.page.title',
            ))
            ->add('name', 'text', array(
                'label' => 'symedit.form.page.name.label',
                'help_label_popover' => array(
                    'title' => 'symedit.form.page.name.popover.title',
                    'content' => 'symedit.form.page.name.popover.content',
                ),
            ))
            ->add('parent', 'symedit_page_choose', array(
                'label' => 'symedit.form.page.parent',
            ))
            ->add('tagline', 'text', array(
                'required' => false,
                'label' => 'symedit.form.page.tagline',
            ))
            ->add('display', 'checkbox', array(
                'required' => false,
                'help_block' => 'symedit.form.page.display.help',
                'label' => 'symedit.form.page.display.label',
            ))
        ;
    }

    protected function buildTemplateForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', 'template', array(
                'label' => 'symedit.form.page.template',
            ))
        ;
    }

    protected function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', 'symedit_seo', array(
                'horizontal_label_offset_class' => '',
            ))
            ->add('crawl', 'checkbox', array(
                'required' => false,
                'help_block' => 'symedit.form.page.crawl.help',
                'label' => 'symedit.form.page.crawl.label',
            ))
        ;
    }

    protected function buildSummaryForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height: 250px',
                    'placeholder' => 'Page Summary...',
                 ),
                'label' => 'symedit.form.page.summary',
                'required' => false,
                'label_render' => false,
            ))
        ;
    }

    protected function buildContentForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                    'placeholder' => 'Page Content',
                ),
                'required' => false,
                'label' => 'symedit.form.page.content',
                'label_render' => false,
            ))
        ;
    }

    protected function buildAdvancedForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pageController', 'checkbox', array(
                'required' => false,
                'label' => 'symedit.form.page.pagecontroller',
            ))
            ->add('pageControllerPath', 'text', array(
                'attr' => array('class' => 'span6'),
                'required' => false,
                'label' => 'symedit.form.page.pagecontrollerpath.label',
                'help_block' => 'symedit.form.page.pagecontrollerpath.help',
            ))
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Build basic tab
        $basic = $builder->create('basic', 'tab', array(
            'label' => 'symedit.form.page.tabs.basic',
            'icon' => 'info-sign',
            'inherit_data' => true,
        ));

        $this->buildBasicForm($basic, $options);

        // Build template tab
        $template = $builder->create('template', 'tab', array(
            'label' => 'symedit.form.page.tabs.template',
            'icon' => 'columns',
            'inherit_data' => true,
        ));

        $this->buildTemplateForm($template, $options);

        // Build SEO tab
        $seo = $builder->create('seo', 'tab', array(
            'label' => 'symedit.form.page.tabs.seo',
            'icon' => 'search',
            'inherit_data' => true,
        ));

        $this->buildSeoForm($seo, $options);

        // Build Summary tab
        $summary = $builder->create('summary', 'tab', array(
            'label' => 'symedit.form.page.tabs.summary',
            'icon' => 'file',
            'inherit_data' => true,
            'horizontal' => false,
            'attr' => array(
                'class' => 'full',
            ),
        ));

        $this->buildSummaryForm($summary, $options);

        // Build Content tab
        $content = $builder->create('content', 'tab', array(
            'label' => 'symedit.form.page.tabs.content',
            'icon' => 'file',
            'inherit_data' => true,
            'horizontal' => false,
            'attr' => array(
                'class' => 'full',
            ),
        ));

        $this->buildContentForm($content, $options);

        // Build advanced tab
        $advanced = $builder->create('advanced', 'tab', array(
            'label' => 'symedit.form.page.tabs.advanced',
            'icon' => 'cogs',
            'inherit_data' => true,
        ));

        $this->buildAdvancedForm($advanced, $options);

        // Add all tabs
        $builder
            ->add($basic)
            ->add($template)
            ->add($seo)
            ->add($summary)
            ->add($content)
            ->add($advanced);

        $subscriber = new PageTypeSubscriber();
        $builder->addEventSubscriber($subscriber);
    }

    public function getName()
    {
        return 'symedit_page';
    }
}
