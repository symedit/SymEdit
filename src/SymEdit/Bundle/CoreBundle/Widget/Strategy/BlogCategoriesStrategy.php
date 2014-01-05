<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Model\WidgetInterface;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\Form\FormBuilderInterface;

class BlogCategoriesStrategy extends AbstractWidgetStrategy
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $root = $this->repository->findRoot();

        return $this->render('@SymEdit/Widget/blog-categories.html.twig', array(
            'root' => $root,
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
