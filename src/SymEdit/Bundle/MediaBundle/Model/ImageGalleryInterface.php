<?php

namespace SymEdit\Bundle\MediaBundle\Model;

interface ImageGalleryInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getSlug();

    public function getItems();

    public function addItem(GalleryItemInterface $image);

    public function removeItem(GalleryItemInterface $image);
}