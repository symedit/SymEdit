<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    protected $pageRepository;

    public function __construct(RepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'label' => 'admin.page.tabs.basic',
            'icon' => 'info-sign',
            'inherit_data' => true,
        ));

        $basic
            ->add('title', 'text', array(
                'label' => 'admin.page.title',
            ))
            ->add('name', 'text', array(
                'label' => 'admin.page.name.label',
                'help_label_popover' => array(
                    'title' => 'admin.page.name.popover.title',
                    'content' => 'admin.page.name.popover.content',
                ),
            ));

        /**
         * Fetch Page choices from the recursive iterator, we have to make sure
         * that we allow pages with display = false here so we can't use the
         * default
         */
        $root = $this->pageRepository->findRoot();
        $pageIterator = $this->pageRepository->getIterator(false);
        $iterator = new \RecursiveIteratorIterator($pageIterator, \RecursiveIteratorIterator::SELF_FIRST);

        $choices = array(
            $root->getId() => 'Root',
        );

        foreach ($iterator as $page) {
            if ($page->getHomepage()) {
                continue;
            }
            $choices[$page->getId()] = str_repeat('--', $page->getLevel()).' '.$page->getTitle();
        }

        $basic->add(
            $builder->create('parent', 'choice', array(
                'choices' => $choices,
                'label' => 'admin.page.parent',
            ))->addModelTransformer(new DataTransformer\RepositoryTransformer($this->pageRepository))
        );

        $basic
            ->add('tagline', 'text', array(
                'required' => false,
                'label' => 'admin.page.tagline',
            ))
            ->add('display', 'checkbox', array(
                'required' => false,
                'help_block' => 'admin.page.display.help',
                'label' => 'admin.page.display.label',
            ));

        $template = $builder->create('template', 'tab', array(
            'label' => 'admin.page.tabs.template',
            'icon' => 'columns',
            'inherit_data' => true,
        ));

        $template
            ->add('template', 'symedit_template', array(
                'label' => 'admin.page.template',
            ));

        $seo = $builder->create('seo', 'tab', array(
            'label' => 'admin.page.tabs.seo',
            'icon' => 'search',
            'inherit_data' => true,
        ));

        $seo
            ->add('seo', 'symedit_seo')
            ->add('crawl', 'checkbox', array(
                'required' => false,
                'help_block' => 'admin.page.crawl.help',
                'label' => 'admin.page.crawl.label',
            ));

        $summary = $builder->create('summary', 'tab', array(
            'label' => 'admin.page.tabs.summary',
            'icon' => 'file',
            'inherit_data' => true,
        ));

        $summary
            ->add('summary', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height: 250px',
                 ),
                'label' => 'admin.page.summary',
                'required' => false,
            ));

        $content = $builder->create('content', 'tab', array(
            'label' => 'admin.page.tabs.content',
            'icon' => 'file',
            'inherit_data' => true,
        ));

        $content
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                    'placeholder' => 'Page content here...',
                ),
                'required' => false,
                'label' => 'admin.page.content',
                'horizontal' => false,
                'label_render' => false,
            ));


        $advanced = $builder->create('advanced', 'tab', array(
            'label' => 'admin.page.tabs.advanced',
            'icon' => 'cogs',
            'inherit_data' => true,
        ));

        $advanced
            ->add('pageController', 'checkbox', array(
                'required' => false,
                'label' => 'admin.page.pagecontroller',
            ))
            ->add('pageControllerPath', 'text', array(
                'attr' => array('class' => 'span6'),
                'required' => false,
                'label' => 'admin.page.pagecontrollerpath.label',
                'help_block' => 'admin.page.pagecontrollerpath.help',
            ));


        // Add all tabs
        $builder
            ->add($basic)
            ->add($template)
            ->add($seo)
            ->add($summary)
            ->add($content)
            ->add($advanced);

        $subscriber = new EventListener\PageTypeSubscriber();
        $builder->addEventSubscriber($subscriber);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'tabs_class' => 'nav nav-stacked nav-pills',
        ));
    }

    public function getName()
    {
        return 'symedit_page';
    }
}
