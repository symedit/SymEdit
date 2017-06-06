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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LatestPostStrategy extends AbstractPostStrategy
{
    public function execute(WidgetInterface $widget)
    {
        $post = $this->postRepository->getLatestPost();

        return $this->render($widget, [
            'post' => $post,
            'show_image' => $widget->getOption('show_image'),
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('show_image', CheckboxType::class, [
                'label' => 'Show Image',
                'required' => false,
            ])
        ;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'show_image' => true,
            'template' => '@SymEdit/Widget/Blog/latest-post.html.twig',
        ]);
    }

    public function getName()
    {
        return 'blog_latest_post';
    }

    public function getDescription()
    {
        return 'blog.latest_post';
    }
}
