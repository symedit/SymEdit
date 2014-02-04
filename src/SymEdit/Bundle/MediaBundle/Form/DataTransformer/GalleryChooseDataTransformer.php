<?php

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