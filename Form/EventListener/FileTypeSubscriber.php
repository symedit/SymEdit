<?php

namespace Isometriks\Bundle\SymEditBundle\Form\EventListener; 

use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent; 
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityRepository; 
use Isometriks\Bundle\SymEditBundle\Entity\File; 

class FileTypeSubscriber implements EventSubscriberInterface {
    
    private $factory; 
    private $options; 
    
    public function __construct(FormFactory $factory, array $options)
    {
        $this->factory = $factory; 
        $this->options = $options; 
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData', 
            FormEvents::POST_BIND => 'postBind',
        );
    }
    
    public function postBind(DataEvent $event)
    {
        $data = $event->getData();  
        $form = $event->getForm();
        
        if(!($data instanceof File)){
            return; 
        }
        
        if(!$this->options['required'] && !$data->hasFile()){
            $event->setData(null); 
            return; 
        }
        
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
    
    
    public function preSetData(DataEvent $event)
    {
        $data   = $event->getData(); 
        $form   = $event->getForm(); 
                
        $form->add($this->factory->createNamed('file', 'file', null, array(
            'required' => $this->options['required'], 
            'label' => 'admin.file.file.label', 
            'help_block' => 'admin.file.file.help',
        )));
        
        $require_name = $form->getConfig()->getOption('require_name'); 
        
        // If name is not set, then add the field
        if(($data === null || $data->getName() === null) && $require_name){
            $form->add($this->factory->createNamed('name', 'text', null, array(
                'label' => 'admin.file.name.label', 
                'help_block' => 'admin.file.name.help', 
            ))); 
        }
    }
}