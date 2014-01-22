<?php

namespace SymEdit\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use SymEdit\Bundle\MediaBundle\Upload\UploadManagerInterface;

abstract class AbstractMediaListener implements EventSubscriber
{
    protected $uploadManager;
    protected $className;

    public function __construct(UploadManagerInterface $uploadManager, $className)
    {
        $this->uploadManager = $uploadManager;
        $this->className = $className;
    }

    protected function isValid($object)
    {
        return $object instanceof $this->className;
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