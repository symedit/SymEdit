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

class GalleryStrategy extends AbstractGalleryStrategy
{
    public function execute(WidgetInterface $widget)
    {
        $gallery = $this->getGallery($widget);

        if (!$gallery) {
            return;
        }

        return $this->render($widget, array(
            'gallery' => $gallery,
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('slider', 'entity_property', array(
                'label' => 'Gallery',
                'help_block' => 'Choose gallery to display',
                'class' => $this->repository->getClassName(),
                'property' => 'title',
                'property_value' => 'slug',
            ))
        ;
    }

    public function getDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => '@SymEdit/Widget/Media/gallery.html.twig',
        ));
    }

    public function getName()
    {
        return 'gallery';
    }

    public function getDescription()
    {
        return 'media.gallery';
    }
}
