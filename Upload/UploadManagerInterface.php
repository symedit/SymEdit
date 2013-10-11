<?php

namespace Isometriks\Bundle\MediaBundle\Upload;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

interface UploadManagerInterface
{    
    /**
     * Prepare upload and underlying entity so it can be stored
     * 
     * @param MediaInterface $file
     */
    public function preUpload(MediaInterface $file);
    
    /**
     * Uploads the file
     * 
     * @param MediaInterface $file
     */
    public function upload(MediaInterface $file);

    /**
     * Remove the upload
     * 
     * @param MediaInterface $file
     */
    public function removeUpload(MediaInterface $file);  
}