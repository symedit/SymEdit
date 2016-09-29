<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\MediaBundle\Factory\GalleryItemFactoryInterface;
use SymEdit\Bundle\MediaBundle\Model\GalleryItemInterface;

class GalleryItemFactory implements GalleryItemFactoryInterface
{
    protected $defaultFactory;
    protected $galleryRepository;

    public function __construct(FactoryInterface $defaultFactory, RepositoryInterface $galleryRepository)
    {
        $this->defaultFactory = $defaultFactory;
        $this->galleryRepository = $galleryRepository;
    }

    /**
     * @return GalleryItemInterface
     */
    public function createNew()
    {
        return $this->defaultFactory->createNew();
    }

    /**
     *
     * @param int $galleryId
     * @return GalleryItemInterface
     */
    public function createWithGallery($galleryId)
    {
        $gallery = $this->galleryRepository->find($galleryId);
        $galleryItem = $this->createNew();
        $galleryItem->setGallery($gallery);

        return $galleryItem;
    }
}
