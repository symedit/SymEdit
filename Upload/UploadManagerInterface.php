<?php

namespace Isometriks\Bundle\MediaBundle\Upload;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

interface UploadManagerInterface
{    
    /**
     * Prepare upload and underlying entity so it can be stored
     * 
     * @param MediaInterface $media
     */
    public function preUpload(MediaInterface $media);
    
    /**
     * Uploads the file
     * 
     * @param MediaInterface $media
     */
    public function upload(MediaInterface $media);

    /**
     * Remove the upload
     * 
     * @param MediaInterface $media
     */
    public function removeUpload(MediaInterface $media);  
}