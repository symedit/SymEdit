<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository; 

class PageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tagline', 'text', array(
                'attr' => array('class' => 'span4'),
                'required' => false,
                'label' => 'admin.page.tagline'
            ))
            ->add('summary', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor span12', 
                    'style' => 'height: 250px', 
                 ),
                'label' => 'admin.page.summary',
                'required' => false,
            ))
            ->add('title', 'text', array(
                'attr' => array('class' => 'span4'), 
                'label' => 'admin.page.title', 
            ))
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'height:500px',
                ),
                'required' => false,
                'label' => 'admin.page.content', 
            ))
            ->add('seo', new SeoVirtualType())
            ->add('display', 'checkbox', array(
                'required' => false,
                'help_inline' => 'admin.page.display.help',
                'label' => 'admin.page.display.label', 
            ))
            ->add('crawl', 'checkbox', array(
                'required' => false,
                'help_inline' => 'admin.page.crawl.help',
                'label' => 'admin.page.crawl.label', 
            ))
            ->add('pageController', 'checkbox', array(
                'required' => false,
                'label' => 'admin.page.pagecontroller',
                // Bind to Controller
            ))
            ->add('pageControllerPath', 'text', array(
                'attr' => array('class' => 'span6'),
                'required' => false,
                'label' => 'admin.page.pagecontrollerpath.label',
                'help_inline' => 'admin.page.pagecontrollerpath.help',
            ))
            ->add('template', 'symedit_template', array(
                'label' => 'admin.page.template', 
            ));
        
        $subscriber = new EventListener\PageTypeSubscriber($builder->getFormFactory()); 
        $builder->addEventSubscriber($subscriber); 
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Entity\Page', 
            'translation_domain' => 'SymEdit', 
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_pagetype';
    }

}
