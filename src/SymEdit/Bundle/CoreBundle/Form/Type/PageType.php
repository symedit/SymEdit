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

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use SymEdit\Bundle\CoreBundle\Event\DisplayOptionsEvent;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Form\EventListener\PageTypeSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\AbstractType;
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
            ->add('title', TextType::class, array(
                'label' => 'symedit.form.page.title',
            ))
            ->add('name', TextType::class, array(
                'label' => 'symedit.form.page.name.label',
                'help_label_popover' => array(
                    'title' => 'symedit.form.page.name.popover.title',
                    'content' => 'symedit.form.page.name.popover.content',
                    'icon' => 'info-circle',
                ),
            ))
            ->add('parent', 'symedit_page_choose', array(
                'label' => 'symedit.form.page.parent',
            ))
            ->add('tagline', TextType::class, array(
                'required' => false,
                'label' => 'symedit.form.page.tagline',
            ))
            ->add('display', CheckboxType::class, array(
                'required' => false,
                'help_block' => 'symedit.form.page.display.help',
                'label' => 'symedit.form.page.display.label',
            ))
            ->add('image', 'symedit_image_choose', array(
                'required' => false,
                'show_image' => true,
                'label' => 'symedit.form.page.image',
            ))
        ;
    }

    public function buildTemplateForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template', 'template', array(
                'label' => 'symedit.form.page.template',
                'directory' => 'Page',
                'display_layouts' => true,
            ))
        ;
    }

    public function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', 'symedit_seo', array(
                'horizontal_label_offset_class' => '',
            ))
            ->add('crawl', CheckboxType::class, array(
                'required' => false,
                'help_block' => 'symedit.form.page.crawl.help',
                'label' => 'symedit.form.page.crawl.label',
            ))
        ;
    }

    public function buildSummaryForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', TextareaType::class, array(
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

    public function buildContentForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array(
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

    public function buildDisplayOptionsForm(FormBuilderInterface $builder, array $options)
    {
        $optionsEvent = new DisplayOptionsEvent($builder, $options);
        $this->eventDispatcher->dispatch(Events::PAGE_DISPLAY_OPTIONS, $optionsEvent);
    }

    public function buildAdvancedForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pageController', CheckboxType::class, array(
                'required' => false,
                'label' => 'symedit.form.page.pagecontroller',
            ))
            ->add('pageControllerPath', TextType::class, array(
                'attr' => array('class' => 'span6'),
                'required' => false,
                'label' => 'symedit.form.page.pagecontrollerpath.label',
                'help_block' => 'symedit.form.page.pagecontrollerpath.help',
            ))
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
        $resolver->setDefaults(array(
            'tabs_data' => array(
                'basic' => array(
                    'label' => 'symedit.form.page.tabs.basic',
                    'icon' => 'info-circle',
                ),
                'template' => array(
                    'label' => 'symedit.form.page.tabs.template',
                    'icon' => 'columns',
                ),
                'seo' => array(
                    'label' => 'symedit.form.page.tabs.seo',
                    'icon' => 'search',
                    'inherit_data' => true,
                ),
                'summary' => array(
                    'label' => 'symedit.form.page.tabs.summary',
                    'icon' => 'file',
                    'horizontal' => false,
                    'attr' => array(
                        'class' => 'full',
                    ),
                ),
                'content' => array(
                    'label' => 'symedit.form.page.tabs.content',
                    'icon' => 'file',
                    'horizontal' => false,
                    'attr' => array(
                        'class' => 'full',
                    ),
                ),
                'displayOptions' => array(
                    'label' => 'Display',
                    'icon' => 'cog',
                    'inherit_data' => false,
                ),
                'advanced' => array(
                    'label' => 'symedit.form.page.tabs.advanced',
                    'icon' => 'cogs',
                ),
            ),
        ));
    }

    public function getName()
    {
        return 'symedit_page';
    }
}
