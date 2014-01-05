<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', 'text', array(
                'label' => 'First Name', 
                'property_path' => 'profile.firstName',
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last Name',
                'required' => false,
                'property_path' => 'profile.lastName',
            ));                
    }   
    
    public function getName()
    {
        return 'symedit_user_registration';
    }

}