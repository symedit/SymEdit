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

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SocialSettingsSchema implements SchemaInterface
{
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('facebook', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'http://facebook.com'),
            ))
            ->add('twitter', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'http://twitter.com'),
            ))
            ->add('youtube', null, array(
                'label' => 'YouTube',
                'required' => false,
                'attr' => array('placeholder' => 'http://youtube.com'),
            ))
            ->add('google_plus', null, array(
                'label' => 'Google+',
                'required' => false,
                'attr' => array('placeholder' => 'http://plus.google.com'),
            ))
            ->add('linkedin', null, array(
                'label' => 'LinkedIn',
                'required' => false,
                'attr' => array('placeholder' => 'http://linkedin.com'),
            ))
            ->add('pinterest', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'http://pinterest.com'),
            ))
            ->add('instagram', null, array(
                'required' => false,
                'attr' => array('placeholder' => 'http://instagram.com'),
            ))
        ;
    }

    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(array(
                'facebook' => null,
                'twitter' => null,
                'youtube' => null,
                'google_plus' => null,
                'linkedin' => null,
                'pinterest' => null,
                'instagram' => null,
            ))
        ;
    }
}
