<?php

namespace {{{ namespace }}}\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('email', 'email', array(
                'required' => false, 
            ))
            ->add('phone', 'text', array(
                'label' => 'Phone', 
                'required' => false, 
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message', 
                'required' => false, 
            ));
    }

    public function getName()
    {
        return '{{{ namespace_name }}}_contact';
    }
}
