<?php

namespace Isometriks\Bundle\SymEditBundle\Form\EventListener; 

use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent; 
use Symfony\Component\Form\FormFactory;
use Doctrine\ORM\EntityRepository; 

class PageTypeSubscriber implements EventSubscriberInterface {
    
    private $factory; 
    
    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory; 
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData', 
        );
    }
    
    public function preSetData(DataEvent $event)
    {
        $data = $event->getData(); 
        $form = $event->getForm(); 
        
        if($data === null){
            return; 
        }
        
        if(!$data->getHomepage()){
            // Can't edit the name on homepage
            $form->add($this->factory->createNamed('name', 'text', null, array(
                'attr' => array(
                    'class' => 'span4', 
                ), 
                'label' => 'admin.page.name', 
            ))); 
            
            // And parent can't be changed for homepage
            $form->add($this->factory->createNamed('parent', 'entity', null, array(
                'class' => 'IsometriksSymEditBundle:Page', 
                'label' => 'admin.page.parent', 
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                              ->where('p.homepage = false')
                              ->orderBy('p.path');
                },
            )));
        }
    }
}