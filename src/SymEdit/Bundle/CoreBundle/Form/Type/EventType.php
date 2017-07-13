<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use SymEdit\Bundle\EventsBundle\Form\Type\EventType as BaseEventType;
use SymEdit\Bundle\MediaBundle\Form\Type\FileChooseType;
use SymEdit\Bundle\MediaBundle\Form\Type\ImageChooseType;
use SymEdit\Bundle\SeoBundle\Form\Type\SeoType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends BaseEventType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Left blank for tab builder
    }

    public function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', SeoType::class, [
                'horizontal_label_offset_class' => '',
            ])
        ;
    }

    public function buildMediaForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileChooseType::class, [
                'label' => 'symedit.form.event.media.file',
                'required' => false,
            ])
            ->add('image', ImageChooseType::class, [
                'label' => 'symedit.form.event.media.image',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'tabs_data' => [
                'basic' => [
                    'label' => 'symedit.form.event.tab.basic',
                    'icon' => 'info-circle',
                ],
                'seo' => [
                    'label' => 'symedit.form.event.tab.seo',
                    'icon' => 'search',
                ],
                'dateTime' => [
                    'label' => 'symedit.form.event.tab.time',
                    'icon' => 'calendar',
                ],
                'location' => [
                    'label' => 'symedit.form.event.tab.location',
                    'icon' => 'map-marker',
                ],
                'media' => [
                    'label' => 'symedit.form.event.tab.media',
                    'icon' => 'image',
                ]
            ],
        ]);
    }

    public function getName()
    {
        return 'symedit_event';
    }
}
