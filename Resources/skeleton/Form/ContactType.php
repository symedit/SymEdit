<?php

namespace {{{ namespace }}}\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Name', 
                ),
            ))
            ->add('email', 'email', array(
                'required' => false, 
                'attr' => array(
                    'placeholder' => 'Email', 
                ),
            ))
            ->add('phone', 'text', array(
                'label' => 'Phone', 
                'required' => false, 
                'attr' => array(
                    'placeholder' => 'Phone',   
                ),
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message', 
                'required' => false, 
                'attr' => array(
                    'placeholder' => 'Your Message', 
                ), 
            ));
    }

    public function getName()
    {
        return '{{{ namespace_name }}}_contact';
    }
}
