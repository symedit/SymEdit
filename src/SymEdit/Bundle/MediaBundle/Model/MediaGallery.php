<?php

namespace SymEdit\Bundle\MediaBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class MediaGallery implements MediaGalleryInterface
{
    protected $id;
    protected $title;
    protected $slug;
    protected $media;

    public function __construct()
    {
        $this->media = new ArrayCollection();
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

    public function getMedia()
    {
        return $this->media;
    }

    public function addMedia(ImageInterface $media)
    {
        if (!$this->getMedia()->contains($media)) {
            $this->getMedia()->add($media);
        }

        return $this;
    }

    public function removeMedia(ImageInterface $media)
    {
        if ($this->getMedia()->contains($media)) {
            $this->getMedia()->removeElement($media);
        }

        return $this;
    }
}