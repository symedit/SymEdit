<?php

namespace Isometriks\Bundle\MediaBundle\Model;

interface MediaGalleryInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getSlug();
    
    public function getMedia();

    public function addMedia(MediaInterface $media);

    public function removeMedia(MediaInterface $media);
}