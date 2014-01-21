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

    protected function preUpload(MediaInterface $media)
    {
        $this->uploadManager->preUpload($media);
    }

    protected function upload(MediaInterface $media)
    {
        $this->uploadManager->upload($media);
    }

    protected function removeUpload(MediaInterface $media)
    {
        $this->uploadManager->removeUpload($media);
    }
}