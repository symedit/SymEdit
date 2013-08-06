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
                'attr' => array(
                    'placeholder' => 'Name',
                ),
                'constraints' => array(
                    new NotBlank(),
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
                'attr' => array(
                    'placeholder' => 'Phone',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('message', 'textarea', array(
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
