<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Isometriks\Bundle\MediaBundle\Upload\UploadManagerInterface;

abstract class AbstractMediaListener implements EventSubscriber
{
    protected $uploadManager;

    public function __construct(UploadManagerInterface $uploadManager)
    {
        $this->uploadManager = $uploadManager;
    }

    protected function preUpload(MediaInterface $file)
    {
        $this->uploadManager->preUpload($file);
    }

    protected function upload(MediaInterface $file)
    {
        $this->uploadManager->upload($file);
    }

    protected function removeUpload(MediaInterface $file)
    {
        $this->uploadManager->removeUpload($file);
    }
}