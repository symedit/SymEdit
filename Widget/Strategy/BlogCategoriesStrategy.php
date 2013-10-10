<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;

class BlogCategoriesStrategy extends AbstractWidgetStrategy
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $categories = $this->doctrine->getManager()->getRepository('Isometriks\Bundle\SymEditBundle\Model\Category');

        return $this->render('@SymEdit/Widget/blog-categories.html.twig', array(
            'categories' => $categories,
            'counts' => $widget->getOption('counts'),
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('counts', 'checkbox', array(
                'required' => false,
                'label' => 'Display Counts',
                'help_block' => 'Display Category counts next to label',
            ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'counts' => true,
        ));
    }

    public function getName()
    {
        return 'blog_categories';
    }

    public function getDescription()
    {
        return 'Blog Categories';
    }
}