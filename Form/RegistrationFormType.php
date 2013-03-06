<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
                ->add('firstName', 'text', array(
                    'label' => 'First Name', 
                ))
                ->add('lastName', 'text', array(
                    'label' => 'Last Name',
                ))
                ->add('gplus', 'url', array(
                    'label' => 'Google+ Profile URL',
                    'required' => false, 
                ));
    }

    public function getName()
    {
        return 'isometriks_symedit_user_registration';
    }

}