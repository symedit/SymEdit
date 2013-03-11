<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\UserBundle\Form\RegistrationFormType as BaseType;

class UserType extends BaseType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'form', array(
            'virtual' => true, 
            'data_class' => $options['data_class'], 
        )); 
        
        parent::buildForm($basic, $options); 
        
        /*
         *  Remove the plain password, we're editing a user so they
         *  Should have full permission to do so
         */
        $basic->remove('plainPassword'); 
        
        $builder
                ->add($basic)
                ->add('biography', 'textarea', array(
                    'required' => false, 
                    'attr' => array(
                        'class' => 'wysiwyg-editor', 
                    ), 
                    'widget_control_group' => false, 
                ))
                ->add('image', new ImageType(), array(
                    'required' => false, 
                    'require_name' => false, 
                ))
                ->add('roles', 'symedit_role'); 
    }

    public function getName()
    {
        return 'isometriks_symedit_user_form_type';
    }

}