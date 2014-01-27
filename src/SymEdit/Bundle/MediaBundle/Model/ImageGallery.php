<?php

namespace SymEdit\Bundle\MediaBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ImageGallery implements ImageGalleryInterface
{
    protected $id;
    protected $title;
    protected $slug;
    protected $galleryItems;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getGalleryItems()
    {
        return $this->galleryItems;
    }

    public function addGalleryItem(GalleryItemInterface $galleryItem)
    {
        if (!$this->getGalleryItems()->contains($galleryItem)) {
            $this->getGalleryItems()->add($galleryItem);
        }

        return $this;
    }

    public function removeGalleryItem(GalleryItemInterface $galleryItem)
    {
        if ($this->getGalleryItems()->contains($galleryItem)) {
            $this->getGalleryItems()->removeElement($galleryItem);
        }

        return $this;
    }
}