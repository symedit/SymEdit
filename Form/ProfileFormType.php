<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
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
                ));;
        
        parent::buildForm($builder, $options);
        
        $builder
                ->add('roles', 'symedit_role'); 
    }

    public function getName()
    {
        return 'isometriks_symedit_user_profile';
    }

}