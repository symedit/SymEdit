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

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class RecentPostsStrategy extends AbstractPostStrategy
{
    public function execute(WidgetInterface $widget)
    {
        $posts = $this->postRepository->getRecent($widget->getOption('max'));

        return $this->render($widget, [
            'posts' => $posts,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('max', IntegerType::class, [
                'label' => 'Max Posts',
                'help_block' => 'Maximum Posts to display in Widget',
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'minMessage' => 'Minimum posts is 1, if you want less disable the widget.',
                    ]),
                ],
            ])
        ;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'max' => 3,
            'template' => '@SymEdit/Widget/Blog/recent-posts.html.twig',
        ]);
    }

    public function getName()
    {
        return 'blog_recent_posts';
    }

    public function getDescription()
    {
        return 'blog.recent_posts';
    }
}
