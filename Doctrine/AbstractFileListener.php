<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Isometriks\Bundle\MediaBundle\Model\FileInterface;
use Isometriks\Bundle\MediaBundle\Upload\UploadManagerInterface;

abstract class AbstractFileListener implements EventSubscriber
{
    protected $uploadManager;
    
    public function __construct(UploadManagerInterface $uploadManager)
    {
        $this->uploadManager = $uploadManager;
    }
    
    protected function preUpload(FileInterface $file)
    {
        $this->uploadManager->preUpload($file);
    }
    
    protected function upload(FileInterface $file)
    {
        $this->uploadManager->upload($file);
    }

    protected function removeUpload(FileInterface $file)
    {
        $this->uploadManager->removeUpload($file);
    }
}