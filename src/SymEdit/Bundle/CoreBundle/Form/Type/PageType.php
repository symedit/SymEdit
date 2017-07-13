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

use SymEdit\Bundle\CoreBundle\Event\DisplayOptionsEvent;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Form\EventListener\PageTypeSubscriber;
use SymEdit\Bundle\MediaBundle\Form\Type\ImageChooseType;
use SymEdit\Bundle\SeoBundle\Form\Type\SeoType;
use SymEdit\Bundle\ThemeBundle\Form\Type\TemplateType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'symedit.form.page.title',
            ])
            ->add('name', TextType::class, [
                'label' => 'symedit.form.page.name.label',
                'help_label_popover' => [
                    'title' => 'symedit.form.page.name.popover.title',
                    'content' => 'symedit.form.page.name.popover.content',
                    'icon' => 'info-circle',
                ],
            ])
            ->add('parent', PageChooseType::class, [
                'label' => 'symedit.form.page.parent',
            ])
            ->add('tagline', TextType::class, [
                'required' => false,
                'label' => 'symedit.form.page.tagline',
            ])
            ->add('display', CheckboxType::class, [
                'required' => false,
                'help_block' => 'symedit.form.page.display.help',
                'label' => 'symedit.form.page.display.label',
            ])
            ->add('image', ImageChooseType::class, [
                'required' => false,
                'show_image' => true,
                'label' => 'symedit.form.page.image',
            ])
        ;
    }

    public function buildTemplateForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', TemplateType::class, [
                'label' => 'symedit.form.page.template',
                'directory' => 'Page',
                'display_layouts' => true,
            ])
        ;
    }

    public function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', SeoType::class, [
                'horizontal_label_offset_class' => '',
            ])
            ->add('crawl', CheckboxType::class, [
                'required' => false,
                'help_block' => 'symedit.form.page.crawl.help',
                'label' => 'symedit.form.page.crawl.label',
            ])
        ;
    }

    public function buildSummaryForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', TextareaType::class, [
                'attr' => [
                    'class' => 'wysiwyg-editor',
                    'style' => 'height: 250px',
                    'placeholder' => 'Page Summary...',
                 ],
                'label' => 'symedit.form.page.summary',
                'required' => false,
                'label_render' => false,
            ])
        ;
    }

    public function buildContentForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                    'placeholder' => 'Page Content',
                ],
                'required' => false,
                'label' => 'symedit.form.page.content',
                'label_render' => false,
            ])
        ;
    }

    public function buildDisplayOptionsForm(FormBuilderInterface $builder, array $options)
    {
        $optionsEvent = new DisplayOptionsEvent($builder, $options);
        $this->eventDispatcher->dispatch(Events::PAGE_DISPLAY_OPTIONS, $optionsEvent);
    }

    public function buildAdvancedForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pageController', CheckboxType::class, [
                'required' => false,
                'label' => 'symedit.form.page.pagecontroller',
            ])
            ->add('pageControllerPath', TextType::class, [
                'attr' => ['class' => 'span6'],
                'required' => false,
                'label' => 'symedit.form.page.pagecontrollerpath.label',
                'help_block' => 'symedit.form.page.pagecontrollerpath.help',
            ])
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Forms built from other methods and tab options in configureOptions

        $subscriber = new PageTypeSubscriber();
        $builder->addEventSubscriber($subscriber);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'tabs_data' => [
                'basic' => [
                    'label' => 'symedit.form.page.tabs.basic',
                    'icon' => 'info-circle',
                ],
                'template' => [
                    'label' => 'symedit.form.page.tabs.template',
                    'icon' => 'columns',
                ],
                'seo' => [
                    'label' => 'symedit.form.page.tabs.seo',
                    'icon' => 'search',
                    'inherit_data' => true,
                ],
                'summary' => [
                    'label' => 'symedit.form.page.tabs.summary',
                    'icon' => 'file',
                    'horizontal' => false,
                    'attr' => [
                        'class' => 'full',
                    ],
                ],
                'content' => [
                    'label' => 'symedit.form.page.tabs.content',
                    'icon' => 'file',
                    'horizontal' => false,
                    'attr' => [
                        'class' => 'full',
                    ],
                ],
                'displayOptions' => [
                    'label' => 'Display',
                    'icon' => 'cog',
                    'inherit_data' => false,
                ],
                'advanced' => [
                    'label' => 'symedit.form.page.tabs.advanced',
                    'icon' => 'cogs',
                ],
            ],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'symedit_page';
    }
}
