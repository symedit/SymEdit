<?php

namespace Isometriks\Bundle\MediaBundle\Model;

interface MediaGalleryManagerInterface
{
    public function getClass();
    public function createGallery();
    
    /**
     * @return MediaGalleryInterface $gallery
     */
    public function find($id);
    
    /**
     * @return MediaGalleryInterface
     */
    public function findAll();
    
    /**
     * @return MediaGalleryInterface
     */
    public function findGalleryBy(array $criteria);
    
    public function deleteGallery(MediaGalleryInterface $gallery);
    
    public function updateGallery(MediaGalleryInterface $gallery, $andFlush = true);
}