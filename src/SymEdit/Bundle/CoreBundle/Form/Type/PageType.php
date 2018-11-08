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
use SymEdit\Bundle\ThemeBundle\Form\Type\TemplateType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
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
            ->add('template', TemplateType::class, [
                'label' => 'symedit.form.page.template',
                'directory' => 'Page',
                'display_layouts' => true,
            ])
            ->add('crawl', CheckboxType::class, [
                'required' => false,
                'help_block' => 'symedit.form.page.crawl.help',
                'label' => 'symedit.form.page.crawl.label',
            ])
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

        // Build Display Options
        $displayOptionsBuilder = $builder->create('displayOptions', FormType::class);
        $optionsEvent = new DisplayOptionsEvent($displayOptionsBuilder, $options);
        $this->eventDispatcher->dispatch(Events::PAGE_DISPLAY_OPTIONS, $optionsEvent);

        // And add to form
        $builder->add($displayOptionsBuilder);

        // Add Page Subscriber
        $subscriber = new PageTypeSubscriber();
        $builder->addEventSubscriber($subscriber);
    }

    public function getBlockPrefix()
    {
        return 'symedit_page';
    }
}
