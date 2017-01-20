<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Form\Type;

use SymEdit\Bundle\UserBundle\Form\Type\UserProfileType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminProfileType extends BaseType
{
    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildBasicForm($builder, $options);

        $builder
            ->add('display', 'checkbox', [
                'label' => 'Display',
                'required' => false,
                'property_path' => 'profile.display',
                'help_block' => 'Display this user on team pages',
            ])
        ;
    }

    protected function buildSocialForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('facebook', 'url', [
                'label' => 'Facebook',
                'attr' => [
                    'placeholder' => 'http://facebook.com',
                ],
            ])
            ->add('twitter', 'url', [
                'label' => 'Twitter',
                'attr' => [
                    'placeholder' => 'http://twitter.com',
                ],
            ])
            ->add('youtube', 'url', [
                'label' => 'YouTube',
                'attr' => [
                    'placeholder' => 'http://youtube.com',
                ],
            ])
            ->add('google_plus', 'url', [
                'label' => 'Google+',
                'attr' => [
                    'placeholder' => 'http://plus.google.com',
                ],
            ])
            ->add('linkedin', 'url', [
                'label' => 'LinkedIn',
                'attr' => [
                    'placeholder' => 'http://linkedin.com',
                ],
            ])
        ;
    }

    protected function buildSummaryForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', 'textarea', [
                'required' => false,
                'label_render' => false,
                'attr' => [
                    'class' => 'wysiwyg-editor',
                    'style' => 'min-height: 300px',
                    'placeholder' => 'User Summary...',
                ],
                'property_path' => 'profile.summary',
            ])
        ;
    }

    protected function buildBiographyForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('biography', 'textarea', [
                'required' => false,
                'label_render' => false,
                'attr' => [
                    'class' => 'wysiwyg-editor',
                    'style' => 'min-height: 500px',
                    'placeholder' => 'User Biography...',
                ],
                'property_path' => 'profile.biography',
            ])
        ;
    }

    protected function buildImageForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', 'symedit_image_choose', [
                'required' => false,
                'property_path' => 'profile.image',
            ])
        ;
    }

    protected function buildRolesForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', 'symedit_role')
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Create basic tab
        $basic = $builder->create('basic', 'tab', [
            'inherit_data' => true,
            'label' => 'Basic',
        ]);

        $this->buildBasicForm($basic, $options);

        // Create social tab
        $social = $builder->create('social', 'tab', [
            'label' => 'Social',
            'required' => false,
            'property_path' => 'profile.social',
        ]);

        $this->buildSocialForm($social, $options);

        // Create summary tab
        $summary = $builder->create('summary', 'tab', [
            'label' => 'Summary',
            'inherit_data' => true,
            'horizontal' => false,
            'attr' => [
                'class' => 'full',
            ],
        ]);

        $this->buildSummaryForm($summary, $options);

        // Create biography tab
        $biography = $builder->create('biography', 'tab', [
            'label' => 'Biography',
            'inherit_data' => true,
            'horizontal' => false,
            'attr' => [
                'class' => 'full',
            ],
        ]);

        $this->buildBiographyForm($biography, $options);

        // Create image tab
        $image = $builder->create('image', 'tab', [
            'label' => 'Image',
            'inherit_data' => true,
        ]);

        $this->buildImageForm($image, $options);

        // Create roles tab
        $roles = $builder->create('roles', 'tab', [
            'label' => 'Roles',
            'inherit_data' => true,
        ]);

        $this->buildRolesForm($roles, $options);

        /*
         * Build rest of form
         */
        $builder
            ->add($basic)
            ->add($social)
            ->add($summary)
            ->add($biography)
            ->add($image)
            ->add($roles)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setDefault('tabs_class', 'nav nav-stacked');
    }

    public function getName()
    {
        return 'symedit_admin_profile';
    }
}
