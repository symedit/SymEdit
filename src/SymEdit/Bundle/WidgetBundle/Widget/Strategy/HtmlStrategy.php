<?php

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;

class HtmlStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        return $widget->getOption('html');
    }

    public function getName()
    {
        return 'html';
    }

    public function getDescription()
    {
        return 'Plain HTML';
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
}
