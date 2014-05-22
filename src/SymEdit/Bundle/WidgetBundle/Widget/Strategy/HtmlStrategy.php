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
use Symfony\Component\Form\FormBuilderInterface;

class HtmlStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render('@SymEdit/Widget/html.html.twig', array(
            'html' => $widget->getOption('html'),
        ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'html' => 'New HTML Widget',
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('html', 'textarea', array(
                'horizontal' => false,
                'label_render' => false,
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                )
            ));
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
