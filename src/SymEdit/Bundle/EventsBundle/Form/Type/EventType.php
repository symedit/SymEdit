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

use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventType extends AbstractType
{
    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'symedit.form.event.basic.title',
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'symedit.form.event.basic.description',
                'attr' => array(
                    'rows' => 5,
                ),
            ))
            ->add('url', UrlType::class, array(
                'label' => 'symedit.form.event.basic.url',
                'required' => false,
            ))
            ->add('email', EmailType::class, array(
                'label' => 'symedit.form.event.basic.email',
                'required' => false,
            ))
            ->add('phone', TextType::class, array(
                'label' => 'symedit.form.event.basic.phone',
                'required' => false,
            ))
            ->add('price', TextType::class, array(
                'label' => 'symedit.form.event.basic.price',
                'required' => false,
            ))
        ;
    }

    public function buildDateTimeForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventStart', DateTimeType::class, array(
                'label' => 'symedit.form.event.time.start',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => array(
                    'class' => 'datetimepicker',
                ),
            ))
            ->add('eventEnd', DateTimeType::class, array(
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

    public function buildLocationForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', TextType::class, array(
                'label' => 'symedit.form.event.location.address',
                'required' => false,
            ))
            ->add('showMap', CheckboxType::class, array(
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
