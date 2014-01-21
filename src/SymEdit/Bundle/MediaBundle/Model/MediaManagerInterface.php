<?php

namespace Isometriks\Bundle\MediaBundle\Model;

interface MediaManagerInterface
{
    public function getClass();
    public function createMedia();
    
    /**
     * @return MediaInterface $media
     */
    public function find($id);
    
    /**
     * @return MediaInterface
     */
    public function findAll();
    
    /**
     * @return MediaInterface
     */
    public function findMediaBy(array $criteria);
    
    public function deleteMedia(MediaInterface $media);
    
    public function updateMedia(MediaInterface $media, $andFlush = true);
}