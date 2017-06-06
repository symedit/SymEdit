<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HtmlStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render($widget, [
            'html' => $widget->getOption('html'),
        ]);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'html' => 'New HTML Widget',
            'template' => '@SymEdit/Widget/html.html.twig',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('html', TextareaType::class, [
                'horizontal' => false,
                'label_render' => false,
                'attr' => [
                    'class' => 'wysiwyg-editor',
                ],
            ])
        ;
    }

    public function getName()
    {
        return 'html';
    }

    public function getDescription()
    {
        return 'widget.html';
    }
}
