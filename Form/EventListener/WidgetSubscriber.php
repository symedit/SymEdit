<?php

namespace Isometriks\Bundle\SymEditBundle\Form\EventListener; 
 
use Symfony\Component\EventDispatcher\EventSubscriberInterface; 
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent; 
use Isometriks\Bundle\SymEditBundle\Model\Widget; 
use Isometriks\Bundle\SymEditBundle\Form\DataTransformer\WidgetAssociationTransformer; 

class WidgetSubscriber implements EventSubscriberInterface 
{
    private $class; 
    private $builder; 
    
    public function __construct(FormBuilderInterface $builder, $class)
    {
        $this->builder = $builder; 
        $this->class = $class; 
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData', 
        );
    }
    
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm(); 
        $transformer = new WidgetAssociationTransformer();
        
        $form
            ->add('title')
            ->add('area', 'entity', array(
                'property' => 'area', 
                'class' => $this->class, 
            ))
            ->add('visibility', 'choice', array(
                'label' => 'Visibility', 
                'choices' => array(
                    Widget::INCLUDE_ALL => 'Include on ALL Pages', 
                    Widget::INCLUDE_ONLY => 'Include ONLY on specified', 
                    Widget::EXCLUDE_ONLY => 'Exclude ONLY on specified', 
                ), 
            ))
            ->add(
                $this->builder->create('assoc', 'textarea', array(
                    'auto_initialize' => false, 
                    'attr' => array(
                        'rows' => 8, 
                    ),
                ))->addModelTransformer($transformer)->getForm()
            ); 
    }
}