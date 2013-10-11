<?php

namespace Isometriks\Bundle\MediaBundle\Upload;

use Isometriks\Bundle\MediaBundle\Model\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadManager implements UploadManagerInterface
{
    protected $uploadDir;
    
    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }
    
    public function preUpload(FileInterface $file)
    {
        
    }
    
    /**
     * Uploads the file
     * 
     * @param FileInterface $file
     */
    public function upload(FileInterface $file)
    {
        $uploadedFile = $file->getFile();
        
        if (!$uploadedFile instanceof UploadedFile) {
            return;
        }
        
        $uploadedFile->move($this->uploadDir, $file->getUploadName());
        chmod($file->getAbsolutePath(), 0644);
        
        // Mark as null to not upload again
        $file->setFile(null);
    }

    public function removeUpload(FileInterface $file)
    {
        
    }    
}