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

use SymEdit\Bundle\CoreBundle\Form\Type\RoleType;
use SymEdit\Bundle\MediaBundle\Form\Type\ImageChooseType;
use SymEdit\Bundle\UserBundle\Form\Type\UserProfileType as BaseType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('display', CheckboxType::class, [
                'label' => 'Display',
                'required' => false,
                'property_path' => 'profile.display',
                'help_block' => 'Display this user on team pages',
            ])
            ->add('facebook', UrlType::class, [
                'label' => 'Facebook',
                'property_path' => 'profile.social[facebook]',
                'attr' => [
                    'placeholder' => 'http://facebook.com',
                ],
            ])
            ->add('twitter', UrlType::class, [
                'label' => 'Twitter',
                'property_path' => 'profile.social[facebook]',
                'attr' => [
                    'placeholder' => 'http://twitter.com',
                ],
            ])
            ->add('youtube', UrlType::class, [
                'label' => 'YouTube',
                'property_path' => 'profile.social[facebook]',
                'attr' => [
                    'placeholder' => 'http://youtube.com',
                ],
            ])
            ->add('google_plus', UrlType::class, [
                'label' => 'Google+',
                'property_path' => 'profile.social[facebook]',
                'attr' => [
                    'placeholder' => 'http://plus.google.com',
                ],
            ])
            ->add('linkedin', UrlType::class, [
                'label' => 'LinkedIn',
                'property_path' => 'profile.social[facebook]',
                'attr' => [
                    'placeholder' => 'http://linkedin.com',
                ],
            ])
            ->add('summary', TextareaType::class, [
                'required' => false,
                'label_render' => false,
                'attr' => [
                    'class' => 'wysiwyg-editor',
                    'style' => 'min-height: 300px',
                    'placeholder' => 'User Summary...',
                ],
                'property_path' => 'profile.summary',
            ])
            ->add('biography', TextareaType::class, [
                'required' => false,
                'label_render' => false,
                'attr' => [
                    'class' => 'wysiwyg-editor',
                    'style' => 'min-height: 500px',
                    'placeholder' => 'User Biography...',
                ],
                'property_path' => 'profile.biography',
            ])
            ->add('image', ImageChooseType::class, [
                'required' => false,
                'property_path' => 'profile.image',
            ])
            ->add('roles', RoleType::class)
        ;
    }


    public function getName()
    {
        return 'symedit_admin_profile';
    }
}
