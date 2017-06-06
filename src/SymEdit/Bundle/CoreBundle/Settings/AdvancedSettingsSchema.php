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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvancedSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('caching', ChoiceType::class, [
                'label' => 'symedit.settings.advanced.caching',
                'choices' => [
                    'No Cache' => 'none',
                    'Cache' => 'cache',
                ],
            ])
            ->add('ttl', IntegerType::class, [
                'label' => 'symedit.settings.advanced.ttl',
            ])
            ->add('widget_max_age', IntegerType::class, [
                'label' => 'symedit.settings.advanced.widget_max_age.label',
                'help_block' => 'symedit.settings.advanced.widget_max_age.help',
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'caching' => 'none',
                'ttl' => 120,
                'widget_max_age' => 300,
            ])
        ;
    }
}
