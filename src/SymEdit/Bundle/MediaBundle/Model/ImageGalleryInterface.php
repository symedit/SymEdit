<?php

namespace SymEdit\Bundle\MediaBundle\Model;

interface ImageGalleryInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getSlug();

    public function getGalleryItems();

    public function addGalleryItem(GalleryItemInterface $image);

    public function removeGalleryItem(GalleryItemInterface $image);
}