<?php

namespace SymEdit\Bundle\EventsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'symedit.form.event.basic.title',
            ))
            ->add('description', 'textarea', array(
                'label' => 'symedit.form.event.basic.description',
            ))
            ->add('url', 'url', array(
                'label' => 'symedit.form.event.basic.url',
                'required' => false,
            ))
            ->add('email', 'email', array(
                'label' => 'symedit.form.event.basic.email',
                'required' => false,
            ))
            ->add('phone', 'text', array(
                'label' => 'symedit.form.event.basic.phone',
                'required' => false,
            ))
            ->add('price', 'text', array(
                'label' => 'symedit.form.event.basic.price',
                'required' => 'false',
            ))
        ;
    }

    protected function buildDateTimeForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventStart', 'datetime', array(
                'label' => 'symedit.form.event.time.start',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => array(
                    'class' => 'datetimepicker',
                ),
            ))
            ->add('eventEnd', 'datetime', array(
                'label' => 'symedit.form.event.time.end',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array(
                    'class' => 'datetimepicker',
                ),
                'required' => false,
            ))
        ;
    }

    protected function buildLocationForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', 'text', array(
                'label' => 'symedit.form.event.location.address',
                'required' => false,
            ))
            ->add('showMap', 'checkbox', array(
                'label' => 'symedit.form.event.location.show_map',
                'required' => false,
                'label' => 'Show Map?',
            ))
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildBasicForm($builder, $options);
        $this->buildDateTimeForm($builder, $options);
        $this->buildLocationForm($builder, $options);
    }

    public function getName()
    {
        return 'symedit_event';
    }
}