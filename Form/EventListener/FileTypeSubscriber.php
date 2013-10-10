<?php

namespace Isometriks\Bundle\MediaBundle\Form\EventListener; 

use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent; 
use Isometriks\Bundle\MediaBundle\Entity\File; 

class FileTypeSubscriber implements EventSubscriberInterface 
{
    private $options; 
    
    public function __construct(array $options)
    {
        $this->options = $options; 
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA  => 'preSetData', 
            FormEvents::POST_BIND     => 'postBind',
            FormEvents::BIND          => 'bind', 
        );
    }
    
    public function bind(FormEvent $event)
    {
        $data = $event->getData(); 
        
        if(!$data instanceof File){
            return; 
        }
        
        $data->calculatePath();  
    }
    
    public function postBind(FormEvent $event)
    {
        $data = $event->getData();  
        $form = $event->getForm();
        
        /**
         * @TODO: Need to change this to Media, not File with the new implementation
         */
        if(!($data instanceof File)){
            return; 
        }
        
        if(!$this->options['required'] && !$data->hasFile()){
            $event->setData(null); 
            return; 
        }
        
        /**
         * Force the file to calculate its path 
         */
        $data->calculatePath(); 
        
        $strategy = $this->options['strategy'];
        if($strategy === 'callback'){
            $name = call_user_func_array($this->options['callback'], array($form)); 
            $data->setName($name);
            
        }
        
        $parent_update = $this->options['parent_update'];
        if($parent_update !== null){
            $parent = $form->getParent()->getData(); 
            
            if(!method_exists($parent, $parent_update)){ 
                throw new \Exception(sprintf('Called parent_update method "%s", but it was not found for class "%s"', $parent_update, get_class($parent))); 
            }
            
            $parent->$parent_update(); 
        }
    }
    
    public function preSetData(FormEvent $event)
    {
        $data   = $event->getData(); 
        $form   = $event->getForm(); 
        
        $form->add('file', 'file', array(
            'required'          => $data === null && $this->options['required'], 
            'label'             => $this->options['file_label'], 
            'help_block'        => $this->options['file_help'],
        ));
        
        $require_name = $form->getConfig()->getOption('require_name'); 
        
        // If name is not set, then add the field
        if(($data === null || $data->getName() === null) && $require_name){
            $form->add('name', 'text', array(
                'label' => $this->options['name_label'], 
                'help_block' => $this->options['name_help'],
            )); 
        }
    }
}