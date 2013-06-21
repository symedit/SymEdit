<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Symfony\Component\Validator\Constraints\NotBlank; 

class TemplateStrategy extends AbstractWidgetStrategy
{
    private $host_bundle;
    private $twig; 
    
    public function __construct($host_bundle, \Twig_Environment $twig)
    {
        $this->host_bundle = $host_bundle;
        $this->twig = $twig; 
    }

    public function execute(WidgetInterface $widget)
    {        
        try {
            $content = $this->twig->render($widget->getOption('template')); 
        } catch(\Exception $e){
            $content = sprintf('There was an error rendering your template: "%s"', $e->getMessage()); 
        }
        
        return $content; 
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('template', 'text', array(
                'required' => true, 
                'label' => 'Template', 
                'property_path' => 'options[template]', 
                'constraints' => array(
                    new NotBlank(), 
                ), 
            ));  
    }    
    
    public function getHostBundle()
    {
        return $this->host_bundle; 
    }
    
    public function getName()
    {
        return 'template'; 
    }

    public function getDescription()
    {
        return 'Template'; 
    }
}