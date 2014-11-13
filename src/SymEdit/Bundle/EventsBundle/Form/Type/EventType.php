<?php

namespace SymEdit\Bundle\EventsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $info = $builder->create('information', 'tab', array(
            'inherit_data' => true,
            'label' => 'Basic Information',
            'icon' => 'info-sign',
        ));

        // Basic Information Tab
        $info
            ->add('title')
            ->add('description')
            ->add('url', 'url', array(
                'required' => false,
            ))
            ->add('email', 'email', array(
                'required' => false,
            ))
            ->add('phone', 'text', array(
                'required' => false,
            ))
            ->add('price', 'text', array(
                'required' => 'false',
            ))
        ;

        // Date / Time Tab
        $time = $builder->create('time', 'tab', array(
            'inherit_data' => true,
            'label' => 'Time / Date',
            'icon' => 'calendar',
        ));

        $time
            ->add('eventStart', 'datetime', array(
                'widget' => 'single_text',
            ))
            ->add('eventEnd', 'datetime', array(
                'widget' => 'single_text',
                'required' => false,
            ))
        ;

        // Location Tab
        $location = $builder->create('location', 'tab', array(
            'inherit_data' => true,
            'label' => 'Location',
            'icon' => 'map-marker',
        ));

        $location
            ->add('address', 'textarea', array(
                'required' => false,
                'attr' => array(
                    'rows' => 3,
                )
            ))
            ->add('showMap', 'checkbox', array(
                'required' => false,
                'label' => 'Show Map?',
            ))
        ;

        // Add the tabs
        $builder
            ->add($info)
            ->add($time)
            ->add($location)
        ;
    }

    public function getName()
    {
        return 'symedit_event';
    }
}