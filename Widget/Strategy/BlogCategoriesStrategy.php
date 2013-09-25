<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

class BlogCategoriesStrategy extends AbstractWidgetStrategy
{
    private $twig;
    private $doctrine;

    public function __construct(\Twig_Environment $twig, Registry $doctrine)
    {
        $this->twig = $twig;
        $this->doctrine = $doctrine;
    }

    public function execute(WidgetInterface $widget)
    {
        $categories = $this->doctrine->getManager()->getRepository('IsometriksSymEditBundle:Category');

        return $this->twig->render('@SymEdit/Widget/blog-categories.html.twig', array(
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