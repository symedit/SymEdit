<?php

namespace Isometriks\Bundle\SymEditBundle\Editable;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 

abstract class AbstractEditableExtension implements EditableExtensionInterface
{
    protected $templating; 
    
    public function renderView($view, array $parameters = array())
    {
        return $this->getTemplating()->render($view, $parameters); 
    }
    
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating; 
    }

    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating; 
    }
    
    public function getJavascripts()
    {
        return array();
    }
    
    public function getStylesheets()
    {
        return array();
    }
}