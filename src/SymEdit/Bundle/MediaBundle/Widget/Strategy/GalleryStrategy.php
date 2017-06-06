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

use SymEdit\Bundle\CoreBundle\Form\Type\EntityPropertyType;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryStrategy extends AbstractGalleryStrategy
{
    public function execute(WidgetInterface $widget)
    {
        $gallery = $this->getGallery($widget);

        if (!$gallery) {
            return;
        }

        return $this->render($widget, [
            'gallery' => $gallery,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('slider', EntityPropertyType::class, [
                'label' => 'Gallery',
                'help_block' => 'Choose gallery to display',
                'class' => $this->repository->getClassName(),
                'property' => 'title',
                'property_value' => 'slug',
            ])
        ;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SymEdit/Widget/Media/gallery.html.twig',
            'slider' => null,
        ]);
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
