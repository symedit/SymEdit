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

use Doctrine\Common\Collections\ArrayCollection;

class ImageGallery implements ImageGalleryInterface
{
    protected $id;
    protected $title;
    protected $slug;
    protected $items;
    protected $updatedAt;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(GalleryItemInterface $item)
    {
        if (!$this->items->contains($item)) {
            // Update
            $this->setUpdated();

            $item->setGallery($this);
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(GalleryItemInterface $item)
    {
        if ($this->items->contains($item)) {
            // Update
            $this->setUpdated();

            $this->items->removeElement($item);
        }

        return $this;
    }

    protected function setUpdated()
    {
        $this->setUpdatedAt(new \DateTime());

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
