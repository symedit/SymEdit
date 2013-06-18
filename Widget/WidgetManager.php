<?php

namespace Isometriks\Bundle\SymEditBundle\Widget; 

use Doctrine\Bundle\DoctrineBundle\Registry; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetAreaInterface; 

class WidgetManager
{
    private $widgetRepository; 
    private $widgetAreaRepository; 
    private $widgetClass; 
    private $widgetAreaClass; 
    private $em; 
    
    public function __construct($widgetClass, $widgetAreaClass, Registry $doctrine)
    {
        $this->widgetClass = $widgetClass; 
        $this->widgetAreaClass = $widgetAreaClass; 
        
        $this->em = $doctrine->getManager(); 
        
        // This will be injected directly eventually to use ODM / ORM whatever
        $this->widgetRepository = $doctrine->getManager()->getRepository($this->widgetClass); 
        $this->widgetAreaRepository = $doctrine->getManager()->getRepository($this->widgetAreaClass); 
    }
    
    /**
     * @return \Isometriks\Bundle\SymEditBundle\Model\WidgetAreaInterface
     */
    public function getWidgetAreas()
    {
        return $this->widgetAreaRepository->findAll(); 
    }
    
    /**
     * @param string $area
     * @return \Isometriks\Bundle\SymEditBundle\Model\WidgetAreaInterface
     * @throws \Exception
     */
    public function getWidgetArea($area)
    {
        $widgetArea = $this->widgetAreaRepository->findOneBy(array(
            'area' => $area, 
        )); 
        
        if($widgetArea === null){
            throw new \Exception(sprintf('Could not find widget area "%s".', $area)); 
        }
        
        return $widgetArea; 
    }
    
    public function saveWidgetArea(WidgetAreaInterface $area)
    {
        $this->em->persist($area); 
        $this->em->flush($area); 
    }
    
    /**
     * @return WidgetAreaInterface
     */
    public function createWidgetArea()
    {
        $class = $this->getWidgetAreaClass(); 
        return new $class(); 
    }
    
    public function getWidgetAreaClass()
    {
        return $this->widgetAreaClass; 
    }
    
    /**
     * 
     * @return WidgetInterface
     */
    public function getWidgets()
    {
        return $this->widgetRepository->findAll(); 
    }
    
    public function saveWidget(WidgetInterface $widget)
    {
        $this->em->persist($widget); 
        $this->em->flush($widget); 
    }
    
    /**
     * @param array $conditions
     * @return WidgetInterface
     * @throws \Exception
     */
    public function getWidgetBy(array $conditions)
    {
        return $this->widgetRepository->findOneBy($conditions); 
    }
    
    /**
     * @return WidgetInterface
     */
    public function createWidget()
    {
        $class = $this->getWidgetClass(); 
        return new $class(); 
    }
    
    public function getWidgetClass()
    {
        return $this->widgetClass; 
    }
}