<?php

namespace SymEdit\Bundle\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'inherit_data' => true,
            'label' => 'Basic',
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
                'help_block' => 'Display this user on team pages',
            ));

        /**
         * Create social tab
         */
        $social = $builder->create('social', 'tab', array(
            'label' => 'Social',
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

        $summary = $builder->create('summary', 'tab', array(
            'label' => 'Summary',
            'inherit_data' => true,
        ));

        $summary
            ->add('summary', 'textarea', array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'wysiwyg-editor',
                        'style' => 'min-height: 300px',
                    ),
                    'property_path' => 'profile.summary',
              ));

        $biography = $builder->create('biography', 'tab', array(
            'label' => 'Biography',
            'inherit_data' => true,
        ));

        $biography
            ->add('biography', 'textarea', array(
                'required' => false,
                'attr' => array(
                    'class' => 'wysiwyg-editor',
                    'style' => 'min-height: 500px',
                ),
                'property_path' => 'profile.biography',
            ));

        $image = $builder->create('image', 'tab', array(
            'label' => 'Image',
            'inherit_data' => true,
        ));

        $image
            ->add('image', 'symedit_image', array(
                'required' => false,
                'require_name' => false,
                'property_path' => 'profile.image',
            ));

        $roles = $builder->create('roles', 'tab', array(
            'label' => 'Roles',
            'inherit_data' => true,
        ));

        $roles->add('roles', 'symedit_role');

        /**
         * Build rest of form
         */
        $builder
                ->add($basic)
                ->add($social)
                ->add($summary)
                ->add($biography)
                ->add($image)
                ->add($roles);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'tabs_class' => 'nav nav-pills nav-stacked',
        ));
    }

    public function getName()
    {
        return 'symedit_admin_profile';
    }
}