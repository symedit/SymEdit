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

class GalleryItem implements GalleryItemInterface
{
    protected $id;
    protected $gallery;
    protected $image;
    protected $position;

    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setGallery(ImageGalleryInterface $gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * {@inheritDoc}
     */
    public function setImage(ImageInterface $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritDoc}
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPosition()
    {
        return $this->position;
    }
}
