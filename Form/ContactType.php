<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'horizontal' => false,                
                'attr' => array(
                    'placeholder' => 'Name',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('email', 'email', array(
                'horizontal' => false,                
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Email',
                ),
            ))
            ->add('phone', 'text', array(
                'horizontal' => false,                
                'label' => 'Phone',
                'attr' => array(
                    'placeholder' => 'Phone',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('message', 'textarea', array(
                'horizontal' => false,                
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Your Message',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'timed_spam' => true,
            'honeypot' => true,
        ));
    }

    public function getName()
    {
        return 'symedit_contact';
    }
}
