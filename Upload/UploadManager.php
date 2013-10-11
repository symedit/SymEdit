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

    public function preUpload(MediaInterface $file)
    {
        die('thinkinga bout uploading..');
    }

    /**
     * Uploads the file
     *
     * @param MediaInterface $file
     */
    public function upload(MediaInterface $media)
    {
        die('actually was gonna work man!!');

        $file = $media->getFile();

        if (!$file instanceof UploadedFile) {
            return;
        }

        $file->move($this->webRoot.'/'.$this->uploadDir, $media->getUploadName());
        chmod($this->getAbsolutePath($media), 0644);

        // Mark as null to not upload again
        $media->setFile(null);
    }

    public function removeUpload(MediaInterface $file)
    {

    }

    protected function getAbsolutePath(MediaInterface $media)
    {
        return sprintf('%s/%s/%s', $this->webRoot, $this->uploadDir, $media->getUploadName());
    }
}