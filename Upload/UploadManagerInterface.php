<?php

namespace Isometriks\Bundle\MediaBundle\Upload;

use Isometriks\Bundle\MediaBundle\Model\FileInterface;

interface UploadManagerInterface
{    
    /**
     * Prepare upload and underlying entity so it can be stored
     * 
     * @param FileInterface $file
     */
    public function preUpload(FileInterface $file);
    
    /**
     * Uploads the file
     * 
     * @param FileInterface $file
     */
    public function upload(FileInterface $file);

    /**
     * Remove the upload
     * 
     * @param FileInterface $file
     */
    public function removeUpload(FileInterface $file);  
}