<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderStrategy extends AbstractGalleryStrategy
{
    public function execute(WidgetInterface $widget)
    {
        $gallery = $this->getGallery($widget);

        if (!$gallery) {
            return;
        }

        return $this->render('@SymEdit/Widget/Media/slider.html.twig', array(
            'gallery' => $gallery,
            'thumbnails' => $widget->getOption('thumbnails'),
            'stretch' => $widget->getOption('stretch'),
            'controls' => $widget->getOption('controls'),
        ));
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'thumbnails' => false,
            'stretch' => false,
            'controls' => false,
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('slider', 'entity_property', array(
                'label' => 'Slider',
                'help_block' => 'Choose slider to display',
                'class' => $this->repository->getClassName(),
                'property' => 'title',
                'property_value' => 'slug',
            ))
            ->add('thumbnails', 'checkbox', array(
                'label' => 'Show Thumbnails',
                'required' => false,
            ))
            ->add('stretch', 'checkbox', array(
                'label' => 'Stretch',
                'required' => false,
            ))
            ->add('controls', 'checkbox', array(
                'label' => 'Show Controls',
                'required' => false,
            ))
        ;
    }

    public function getName()
    {
        return 'slider';
    }

    public function getDescription()
    {
        return 'media.slider';
    }
}
