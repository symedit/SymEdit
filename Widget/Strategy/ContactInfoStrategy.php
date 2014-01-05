<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;

class ContactInfoStrategy extends TemplateStrategy
{
    /**
     * Return just the regular form, you can't change the template.
     */
    public function buildForm(FormBuilderInterface $builder)
    {
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOption('template', '@SymEdit/Widget/contact-info.html.twig');
    }

    public function getName()
    {
        return 'contact_info';
    }

    public function getDescription()
    {
        return 'Basic Contact Information';
    }
}
