<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Isometriks\Bundle\SymEditBundle\Form\ImageType;

class UserProfileType extends BaseType
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
                'property_path' => 'profile.firstName',
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last Name',
                'required' => false,
                'property_path' => 'profile.lastName',
            ))
            ->add('display', 'checkbox', array(
                'label' => 'Display',
                'required' => false,
                'property_path' => 'profile.display',
                'help_inline' => 'Display this user on team pages',
            ));

        /**
         * Create social tab
         */
        $social = $builder->create('social', 'form', array(
            'required' => false,
            'property_path' => 'profile.social',
        ));

        $social
            ->add('facebook', 'url', array(
                'label' => 'Facebook',
                'attr' => array(
                    'placeholder' => 'http://facebook.com',
                ),
            ))
            ->add('twitter', 'url', array(
                'label' => 'Twitter',
                'attr' => array(
                    'placeholder' => 'http://twitter.com',
                ),
            ))
            ->add('youtube', 'url', array(
                'label' => 'YouTube',
                'attr' => array(
                    'placeholder' => 'http://youtube.com',
                ),
            ))
            ->add('google_plus', 'url', array(
                'label' => 'Google+',
                'attr' => array(
                    'placeholder' => 'http://plus.google.com',
                ),
            ))
            ->add('linkedin', 'url', array(
                'label' => 'LinkedIn',
                'attr' => array(
                    'placeholder' => 'http://linkedin.com',
                ),
            ));

        /**
         * Build rest of form
         */
        $builder
                ->add($basic)
                ->add($social)
                ->add('summary', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'wysiwyg-editor',
                        'style' => 'min-height: 300px',
                    ),
                    'widget_control_group' => false,
                    'property_path' => 'profile.summary',
                ))
                ->add('biography', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'wysiwyg-editor',
                        'style' => 'min-height: 500px',
                    ),
                    'widget_control_group' => false,
                    'property_path' => 'profile.biography',
                ))
                ->add('image', new ImageType(), array(
                    'required' => false,
                    'require_name' => false,
                    'property_path' => 'profile.image',
                ))
                ->add('roles', 'symedit_role');
    }

    public function getName()
    {
        return 'symedit_user_profile';
    }

}