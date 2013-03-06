<?php

namespace Isometriks\Bundle\SymEditBundle\Form\EventListener; 

use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent; 
use Symfony\Component\Form\FormFactory;
use Isometriks\Bundle\SymEditBundle\Form\ImageType; 

class SelectImageSubscriber implements EventSubscriberInterface {
    
    private $factory; 
    
    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory; 
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::BIND_CLIENT_DATA => 'preSetData', 
        );
    }
    
    public function preSetData(DataEvent $event)
    {
        $data = $event->getData(); 
        $form = $event->getForm(); 
        
        if($data === null){
            return; 
        }
        
        if(isset($data['new_image']) && isset($data['new_image']['file'])){
            $data = $data['new_image']; 
            $field = $this->factory->createNamed('image', new ImageType());
            
        } else {
            $data = $data['existing_image']; 
            $field = $this->factory->createNamed('image', 'entity', null, array(
               'class' => 'Isometriks\\Bundle\\SymEditBundle\\Entity\\Image',  
            ));
            
        }      
        
        $form->add($field); 
        $event->setData(array(
            'image' => $data, 
        ));
    }
}