<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Widget\Strategy;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogCategoriesStrategy extends AbstractWidgetStrategy
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(WidgetInterface $widget)
    {
        $root = $this->repository->findRoot();

        return $this->render('@SymEdit/Widget/Blog/categories.html.twig', array(
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

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'counts' => true,
        ));
    }

    public function getName()
    {
        return 'blog_categories';
    }

    public function getDescription()
    {
        return 'blog.blog_categories';
    }
}
