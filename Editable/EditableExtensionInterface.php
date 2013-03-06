<?php

namespace Isometriks\Bundle\SymEditBundle\Editable; 

use Symfony\Component\Form\Form; 
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
use Symfony\Component\Security\Core\SecurityContext; 
use Symfony\Component\Form\FormFactory; 

interface EditableExtensionInterface
{
    public function supports(Editable $editable);
    public function execute(Editable $editable, FormFactory $factory, SecurityContext $context); 
    public function renderView($view, array $paramters = array()); 
    public function getTemplating(); 
    public function setTemplating(EngineInterface $templating); 
    public function getJavascripts(); 
    public function getStylesheets(); 
}