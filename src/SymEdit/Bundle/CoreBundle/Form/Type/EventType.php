<?php

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use SymEdit\Bundle\EventsBundle\Form\Type\EventType as BaseEventType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends BaseEventType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Build basic form
        $basic = $builder->create('information', 'tab', array(
            'inherit_data' => true,
            'label' => 'symedit.form.event.tab.basic',
            'icon' => 'info-sign',
        ));

        $this->buildBasicForm($basic, $options);

        // Date / Time Form
        $time = $builder->create('time', 'tab', array(
            'inherit_data' => true,
            'label' => 'symedit.form.event.tab.time',
            'icon' => 'calendar',
        ));

        $this->buildDateTimeForm($time, $options);

        // Build Location Form
        $location = $builder->create('location', 'tab', array(
            'inherit_data' => true,
            'label' => 'symedit.form.event.tab.location',
            'icon' => 'map-marker',
        ));

        $this->buildLocationForm($location, $options);

        // Add the tabs
        $builder
            ->add($basic)
            ->add($time)
            ->add($location)
        ;
    }

    public function getName()
    {
        return 'symedit_event';
    }
}