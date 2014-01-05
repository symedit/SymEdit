<?php

namespace SymEdit\Bundle\CoreBundle\Form\EventListener; 

use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent; 

class UserTypeSubscriber implements EventSubscriberInterface 
{  
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
        
        $basic = $form->get('basic'); 

        $basic->add('plainPassword', 'repeated', array(
            'required' => $data === null, 
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.password'),
            'second_options' => array('label' => 'form.password_confirmation'),
            'invalid_message' => 'fos_user.password.mismatch',
        ));  
    }
}        