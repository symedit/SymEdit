<?php

namespace SymEdit\Bundle\MediaBundle\Model;

interface ImageGalleryInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getSlug();

    public function getMedia();

    public function addMedia(ImageInterface $media);

    public function removeMedia(ImageInterface $media);
}