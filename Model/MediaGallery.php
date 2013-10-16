<?php

namespace Isometriks\Bundle\MediaBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class MediaGallery implements MediaGalleryInterface
{
    protected $id;
    protected $title;
    protected $slug;
    protected $media;
    
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
        return $this->media ?: $this->media = new ArrayCollection();
    }
    
    public function addMedia(MediaInterface $media)
    {
        if (!$this->getMedia()->contains($media)) {
            $this->getMedia()->add($media);
        }
        
        return $this;
    }

    public function removeMedia(MediaInterface $media)
    {
        if ($this->getMedia()->contains($media)) {
            $this->getMedia()->removeElement($media);
        }
        
        return $this;
    }
}