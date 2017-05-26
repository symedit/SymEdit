<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use SymEdit\Bundle\MediaBundle\Form\EventListener\FileTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new FileTypeSubscriber($options));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'require_name' => true,
            'required' => true,
            'allow_remove' => false,
            'callback' => null,
            'file_label' => 'File',
            'file_help' => false,
            'name_label' => 'File Name',
            'name_help' => false,
            'allow_blank_name' => false,
            'validation_groups' => [$this, 'getValidationGroups'],
        ]);
    }

    public function getValidationGroups(FormInterface $form)
    {
        $config = $form->getConfig();
        $groups = [];

        if ($config->getOption('require_name') && !$config->getOption('allow_blank_name')) {
            $groups[] = 'require_name';
        } else {
            $groups[] = 'file_only';
        }

        if ($config->getOption('required')) {
            $groups[] = 'required';
        }

        return $groups;
    }

    public function getBlockPrefix()
    {
        return 'symedit_media';
    }
}
