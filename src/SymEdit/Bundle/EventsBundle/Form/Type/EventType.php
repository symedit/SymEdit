<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'symedit.form.event.basic.title',
            ])
            ->add('description', 'textarea', [
                'label' => 'symedit.form.event.basic.description',
                'attr' => [
                    'rows' => 5,
                ],
            ])
            ->add('url', 'url', [
                'label' => 'symedit.form.event.basic.url',
                'required' => false,
            ])
            ->add('email', 'email', [
                'label' => 'symedit.form.event.basic.email',
                'required' => false,
            ])
            ->add('phone', 'text', [
                'label' => 'symedit.form.event.basic.phone',
                'required' => false,
            ])
            ->add('price', 'text', [
                'label' => 'symedit.form.event.basic.price',
                'required' => false,
            ])
        ;
    }

    public function buildDateTimeForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventStart', 'datetime', [
                'label' => 'symedit.form.event.time.start',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => [
                    'class' => 'datetimepicker',
                ],
            ])
            ->add('eventEnd', 'datetime', [
                'label' => 'symedit.form.event.time.end',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'datetimepicker',
                ],
                'required' => false,
            ])
        ;
    }

    public function buildLocationForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', 'text', [
                'label' => 'symedit.form.event.location.address',
                'required' => false,
            ])
            ->add('showMap', 'checkbox', [
                'label' => 'symedit.form.event.location.show_map',
                'required' => false,
            ])
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
