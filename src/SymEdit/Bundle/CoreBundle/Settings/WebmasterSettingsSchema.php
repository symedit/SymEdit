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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class WebmasterSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('google_analytics_enabled', ChoiceType::class, [
                'label' => 'symedit.settings.webmaster.google_analytics_enabled',
                'required' => false,
                'choices' => [
                    true => 'Enabled',
                    false => 'Disabled',
                ],
            ])
            ->add('google_analytics', TextType::class, [
                'label' => 'symedit.settings.webmaster.google_analytics',
                'required' => false,
                'attr' => ['placeholder' => 'UA-12345678'],
            ])
            ->add('google_verify', TextType::class, [
                'label' => 'symedit.settings.webmaster.google_verify',
                'required' => false,
                'attr' => ['placeholder' => 'google123456789012'],
            ])
            ->add('bing_verify', TextType::class, [
                'label' => 'symedit.settings.webmaster.bing_verify',
                'required' => false,
            ])
            ->add('robots', ChoiceType::class, [
                'label' => 'symedit.settings.webmaster.robots',
                'choices' => [
                    'deny' => 'Deny All',
                    'allow' => 'Allow All',
                ],
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'google_analytics_enabled' => true,
                'google_analytics' => null,
                'google_verify' => null,
                'bing_verify' => null,
                'robots' => 'deny',
            ])
        ;
    }
}
