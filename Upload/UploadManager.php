<?php

namespace Isometriks\Bundle\MediaBundle\Upload;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadManager implements UploadManagerInterface
{
    protected $webRoot;
    protected $uploadDir;

    public function __construct($webRoot, $uploadDir)
    {
        $this->webRoot = $webRoot;
        $this->uploadDir = $uploadDir;
    }

    /**
     * Prepare file for upload
     */
    public function preUpload(MediaInterface $media)
    {
        if (($callback = $media->getNameCallback()) !== null) {
            $media->setName($callback($media));
        }
        
        if ($media->getFile() !== null) {
            $this->removeUpload($media);
            $media->setPath($this->getUploadPath($media));
        }
    }

    /**
     * Uploads the file
     *
     * @param MediaInterface $media
     */
    public function upload(MediaInterface $media)
    {
        $file = $media->getFile();

        if (!$file instanceof UploadedFile) {
            return;
        }
        
        $absolutePath = $this->webRoot.'/'.$media->getPath(); 

        $file->move(dirname($absolutePath), $media->getUploadName());
        chmod($absolutePath, 0644);

        // Mark as null to not upload again
        $media->setFile(null);
    }

    public function removeUpload(MediaInterface $media)
    {
        if ($media->getPath() === null) {
            return;
        }
        
        $absolutePath = $this->webRoot.'/'.$media->getPath();
        
        if(file_exists($absolutePath)){
            unlink($absolutePath);
        }

        $info = pathinfo($absolutePath);
        $glob = sprintf('%s/cache/%s_*', $info['dirname'], $info['filename']);

        foreach (glob($glob) as $file) {
            unlink($file);
        }
    }
    
    public function getUploadPath(MediaInterface $media)
    {
        return $this->uploadDir.'/'.$media->getUploadName();
    }
}