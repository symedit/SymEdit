<?php

namespace SymEdit\Bundle\EventsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EvenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('eventStart', 'datetime')
            ->add('eventEnd', 'dateime', array(
                'required' => false,
            ))
            ->add('url', 'url', array(
                'required' => false,
            ))
            ->add('email', 'email', array(
                'required' => false,
            ))
            ->add('phone', array(
                'required' => false,
            ))
            ->add('price', 'text', array(
                'required' => 'false',
            ))
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
    }

    public function getName()
    {
        return 'symedit_event';
    }
}