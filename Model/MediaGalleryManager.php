<?php

namespace Isometriks\Bundle\MediaBundle\Model;

abstract class MediaGalleryManager implements MediaGalleryManagerInterface
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return MediaGalleryInterface $file
     */
    public function createGallery()
    {
        $class = $this->getClass();

        return new $class;
    }
}