<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Settings;

use SymEdit\Bundle\MailChimpBundle\Form\Type\ListType;
use SymEdit\Bundle\SettingsBundle\Schema\SchemaInterface;
use SymEdit\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MailChimpSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('api_key', TextType::class, [
                'label' => 'symedit.settings.mailchimp.api_key',
                'required' => false,
                'attr' => ['placeholder' => '1234abc98fe9a1234a987f9a12e123a1-us6'],
            ])
            ->add('default_list', ListType::class, [
                'label' => 'symedit.settings.mailchimp.default_list',
            ])
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults([
                'api_key' => null,
                'default_list' => null,
            ])
        ;
    }
}
