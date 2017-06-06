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

use SymEdit\Bundle\BlogBundle\Repository\CategoryRepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogCategoriesStrategy extends AbstractWidgetStrategy
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(WidgetInterface $widget)
    {
        $root = $this->categoryRepository->findRoot();

        return $this->render($widget, [
            'root' => $root,
            'counts' => $widget->getOption('counts'),
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('counts', CheckboxType::class, [
                'required' => false,
                'label' => 'Display Counts',
                'help_block' => 'Display Category counts next to label',
            ])
        ;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'counts' => true,
            'template' => '@SymEdit/Widget/Blog/categories.html.twig',
        ]);
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
