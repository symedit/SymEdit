<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface GalleryItemInterface extends ResourceInterface
{
    /**
     * @return int $id
     */
    public function getId();

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image);

    /**
     * @return ImageInterface $image
     */
    public function getImage();

    /**
     * @param ImageGalleryInterface $gallery
     */
    public function setGallery(ImageGalleryInterface $gallery);

    /**
     * @return ImageGalleryInterface $gallery
     */
    public function getGallery();

    /**
     * @param string $caption
     */
    public function setCaption($caption);

    /**
     * @return string $caption
     */
    public function getCaption();

    /**
     * @return GalleryItemInterface
     */
    public function setPosition($position);

    /**
     * @return int $position
     */
    public function getPosition();
}
