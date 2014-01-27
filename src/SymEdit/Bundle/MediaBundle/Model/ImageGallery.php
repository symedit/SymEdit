<?php

namespace SymEdit\Bundle\MediaBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ImageGallery implements ImageGalleryInterface
{
    protected $id;
    protected $title;
    protected $slug;
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
            $item->setGallery($this);
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(GalleryItemInterface $item)
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }

        return $this;
    }
}