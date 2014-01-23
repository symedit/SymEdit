<?php

namespace SymEdit\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use SymEdit\Bundle\MediaBundle\Upload\UploadManagerInterface;

abstract class AbstractMediaListener implements EventSubscriber
{
    protected $uploadManager;
    protected $className;
    protected $webPath;

    public function __construct(UploadManagerInterface $uploadManager, $className, $webPath)
    {
        $this->uploadManager = $uploadManager;
        $this->className = $className;
        $this->webPath = $webPath;
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
        $this->setPrefix($media);
    }

    protected function removeUpload(MediaInterface $media)
    {
        $this->uploadManager->removeUpload($media);
    }

    protected function setPrefix(MediaInterface $media)
    {
        $media->setPrefix($this->webPath);
    }
}