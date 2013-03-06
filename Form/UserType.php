<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\UserBundle\Form\RegistrationFormType as BaseType;

class UserType extends BaseType {

    private $edit; 
    
    public function __construct( $class, $edit = false )
    {
        $this->edit = $edit; 
        
        parent::__construct($class); 
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
                ->add('roles', 'symedit_role'); 
        
        if($this->edit){
            $builder->remove('plainPassword'); 
        }
    }

    public function getName()
    {
        return 'isometriks_symedit_user_form_type';
    }

}