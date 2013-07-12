<?php

namespace Isometriks\Bundle\SymEditBundle\Controller; 

use Symfony\Component\HttpFoundation\Request; 
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference; 
use Isometriks\Bundle\SymEditBundle\Controller\Controller; 

class WidgetController extends Controller
{
    public function renderAreaAction(Request $request, $area, $path = null, $id = null)
    {
        $manager = $this->get('isometriks_sym_edit.widget.manager'); 
        $widgetArea = $manager->getWidgetArea($area); 

        $template = new TemplateReference($this->getHostBundle(), 'WidgetArea', $area, 'html', 'twig'); 
        
        if(!$this->templateExists($template)){
            $template->set('name', 'default'); 
        }
        
        $response = $this->createResponse(); 
        $widgets = array();  
        
        foreach($widgetArea->getWidgets() as $widget){
            
            if(!$widget->isVisible(array($path, $id))){
                continue; 
            }
            
            $widgets[] = array(
                'id' => $widget->getId(), 
                'title' => $widget->getTitle(), 
                'content' => $widget->getStrategy()->execute($widget), 
            ); 
        }
        
        return $this->render($template, array(
            'widgetArea' => $widgetArea, 
            'widgets' => $widgets, 
            'area' => $area, 
        ), $response); 
    }
    
    
    private function templateExists($template)
    {
       $loader = $this->get('twig')->getLoader();  
       
       if($loader instanceof \Twig_ExistsLoaderInterface){
           return $loader->exists($template); 
       }
       
       return false; 
    }
}