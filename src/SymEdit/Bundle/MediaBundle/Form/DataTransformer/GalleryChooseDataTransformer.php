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
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\Form\DataTransformerInterface;

class GalleryChooseDataTransformer implements DataTransformerInterface
{
    protected $imageRepository;
    protected $itemRepository;

    public function __construct(RepositoryInterface $imageRepository, RepositoryInterface $itemRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->itemRepository = $itemRepository;
    }

    public function reverseTransform($value)
    {
        $images = array_filter($value, function($v){ return $v !== null; });

        $galleryItems = array();
        foreach ($images as $image) {
            $item = $this->itemRepository->createNew();
            $item->setImage($image);

            $galleryItems[] = $item;
        }

        return $galleryItems;
    }

    public function transform($value)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Collection) {
            return $value->toArray();
        }

        return $value;
    }
}