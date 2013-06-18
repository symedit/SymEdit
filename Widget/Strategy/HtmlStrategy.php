<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy; 

use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Symfony\Component\Form\FormBuilderInterface; 

class HtmlStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
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

    public function getForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('html', 'textarea', array(
                'property_path' => 'options[html]', 
                'label_render' => false, 
                'widget_control_group' => false, 
                'attr' => array(
                    'class' => 'wysiwyg-editor', 
                )
            )); 
        
        return $builder->getForm(); 
    }    
}