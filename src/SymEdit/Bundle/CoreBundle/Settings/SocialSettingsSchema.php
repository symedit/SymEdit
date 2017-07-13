<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Settings;

use SymEdit\Bundle\SettingsBundle\Schema\SchemaInterface;
use SymEdit\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SocialSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('facebook', null, [
                'required' => false,
                'attr' => ['placeholder' => 'http://facebook.com'],
            ])
            ->add('twitter', null, [
                'required' => false,
                'attr' => ['placeholder' => 'http://twitter.com'],
            ])
            ->add('youtube', null, [
                'label' => 'YouTube',
                'required' => false,
                'attr' => ['placeholder' => 'http://youtube.com'],
            ])
            ->add('google_plus', null, [
                'label' => 'Google+',
                'required' => false,
                'attr' => ['placeholder' => 'http://plus.google.com'],
            ])
            ->add('linkedin', null, [
                'label' => 'LinkedIn',
                'required' => false,
                'attr' => ['placeholder' => 'http://linkedin.com'],
            ])
            ->add('pinterest', null, [
                'required' => false,
                'attr' => ['placeholder' => 'http://pinterest.com'],
            ])
            ->add('instagram', null, [
                'required' => false,
                'attr' => ['placeholder' => 'http://instagram.com'],
            ])
            ->add('houzz', null, [
                'required' => false,
                'attr' => ['placeholder' => 'http://houzz.com'],
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'facebook' => null,
                'twitter' => null,
                'youtube' => null,
                'google_plus' => null,
                'linkedin' => null,
                'pinterest' => null,
                'instagram' => null,
                'houzz' => null,
            ])
        ;
    }
}
