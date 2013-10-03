<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;

class PageType extends AbstractType 
{
    protected $pageManager;
    
    public function __construct(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'label' => 'Basic',
            'icon' => 'info-sign',
            'inherit_data' => true,
        ));

        $basic
            ->add('title', 'text', array(
                'attr' => array('class' => 'span4'),
                'label' => 'admin.page.title',
            ))
            ->add('name', 'text', array(
                'attr' => array(
                    'class' => 'span4',
                ),
                'label' => 'admin.page.name',
            ));
        
        /**
         * Fetch Page choices from the recursive iterator, we have to make sure
         * that we allow pages with display = false here so we can't use the
         * default
         */
        $root = $this->pageManager->findRoot();
        $pageIterator = new \Isometriks\Bundle\SymEditBundle\Iterator\RecursivePageIterator($root, false);
        $iterator = new \RecursiveIteratorIterator($pageIterator);
        
        $choices = array(
            $root->getId() => 'Root',
        );
        
        foreach ($iterator as $page) {
            $choices[$page->getId()] = str_repeat('--', $page->getLevel()).' '.$page->getTitle();
        }
        
        $basic->add(
            $builder->create('parent', 'choice', array(
                'choices' => $choices,
                'label' => 'admin.page.parent',
            ))->addModelTransformer(new DataTransformer\PageTransformer($this->pageManager))
        );
        
        $basic   
            ->add('tagline', 'text', array(
                'attr' => array('class' => 'span4'),
                'required' => false,
                'label' => 'admin.page.tagline'
            ))
            ->add('display', 'checkbox', array(
                'required' => false,
                'help_inline' => 'admin.page.display.help',
                'label' => 'admin.page.display.label',
            ))
            ->add('summary', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor span12',
                    'style' => 'height: 250px',
                 ),
                'label' => 'admin.page.summary',
                'required' => false,
            ));

        $template = $builder->create('template', 'tab', array(
            'label' => 'Template',
            'icon' => 'columns',
            'inherit_data' => true,
        ));

        $template
            ->add('template', 'symedit_template', array(
                'label' => 'admin.page.template',
            ));

        $seo = $builder->create('seo', 'tab', array(
            'label' => 'SEO',
            'icon' => 'search',
            'inherit_data' => true,
        ));

        $seo
            ->add('seo', new SeoVirtualType())
            ->add('crawl', 'checkbox', array(
                'required' => false,
                'help_inline' => 'admin.page.crawl.help',
                'label' => 'admin.page.crawl.label',
            ));


        $content = $builder->create('content', 'tab', array(
            'label' => 'Content',
            'icon' => 'file',
            'inherit_data' => true,
        ));

        $content
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                ),
                'required' => false,
                'label' => 'admin.page.content',
                'horizontal' => false,
                'label_render' => false,                
            ));


        $advanced = $builder->create('advanced', 'tab', array(
            'label' => 'Advanced',
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
                'help_inline' => 'admin.page.pagecontrollerpath.help',
            ));


        // Add all tabs
        $builder
            ->add($basic)
            ->add($template)
            ->add($seo)
            ->add($content)
            ->add($advanced);

        $subscriber = new EventListener\PageTypeSubscriber();
        $builder->addEventSubscriber($subscriber);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->pageManager->getClass(),
            'translation_domain' => 'SymEdit',
        ));
    }

    public function getName()
    {
        return 'symedit_page';
    }
}
