<?php

namespace Isometriks\Bundle\SymEditBundle\Form\EventListener; 

use Isometriks\Bundle\SymEditBundle\Model\PageInterface; 
use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent; 
use Doctrine\ORM\EntityRepository; 

class PageTypeSubscriber implements EventSubscriberInterface {
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData', 
        );
    }
    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData(); 
        $form = $event->getForm(); 
        
        if($data === null || !$data instanceof PageInterface){
            return; 
        }
        
        if(!$data->getHomepage()){
            // Can't edit the name on homepage
            $form->add('name', 'text', array(
                'attr' => array(
                    'class' => 'span4', 
                ), 
                'label' => 'admin.page.name', 
            )); 
            
            // And parent can't be changed for homepage
            $form->add('parent', 'entity', array(
                'class' => 'IsometriksSymEditBundle:Page', 
                'label' => 'admin.page.parent', 
                
                // TODO: This is a pretty big problem, we can't let them
                // choose the page itself, or choose one of its children 
                // without making a loop. 
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                              ->where('p.homepage = false')
                              ->orderBy('p.path');
                },
            ));
        }
    }
}