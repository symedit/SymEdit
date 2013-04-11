<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Isometriks\Bundle\SymEditBundle\Form\ImageType; 

class ProfileFormType extends BaseType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $basic = $builder->create('basic', 'form', array(
            'virtual' => true, 
            'data_class' => $options['data_class'], 
        )); 
        
        parent::buildForm($basic, $options); 
              
        $basic
            ->add('firstName', 'text', array(
                'label' => 'First Name', 
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last Name',
                'required' => false, 
            ))
            ->add('gplus', 'url', array(
                'label' => 'Google+ Profile URL',
                'required' => false, 
            )); 
        
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
        return 'isometriks_symedit_user_profile';
    }

}