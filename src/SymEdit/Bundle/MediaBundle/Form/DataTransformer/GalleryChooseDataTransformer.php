<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Form\DataTransformer;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Form\DataTransformerInterface;

class GalleryChooseDataTransformer implements DataTransformerInterface
{
    private $itemFactory;

    public function __construct(FactoryInterface $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    public function reverseTransform($value)
    {
        $images = array_filter($value, function ($v) {
            return $v !== null;
        });

        $galleryItems = [];
        foreach ($images as $image) {
            $item = $this->itemFactory->createNew();
            $item->setImage($image);

            $galleryItems[] = $item;
        }

        return $galleryItems;
    }

    public function transform($value)
    {
        if ($value === null) {
            return;
        }

        if ($value instanceof Collection) {
            return $value->toArray();
        }

        return $value;
    }
}
