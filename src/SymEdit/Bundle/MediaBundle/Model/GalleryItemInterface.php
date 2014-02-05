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

interface GalleryItemInterface
{
    /**
     * @return integer $id
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
     * @param GalleryInterface $gallery
     */
    public function setGallery(ImageGalleryInterface $gallery);

    /**
     * @return GalleryInterface $gallery
     */
    public function getGallery();
}