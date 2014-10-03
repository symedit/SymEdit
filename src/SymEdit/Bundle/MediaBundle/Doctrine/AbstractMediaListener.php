<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use SymEdit\Bundle\MediaBundle\Namer\NamerInterface;
use SymEdit\Bundle\MediaBundle\Upload\UploadManagerInterface;

abstract class AbstractMediaListener implements EventSubscriber
{
    protected $uploadManager;
    protected $namer;
    protected $className;
    protected $webPath;

    public function __construct(UploadManagerInterface $uploadManager, NamerInterface $namer, $className, $webPath)
    {
        $this->uploadManager = $uploadManager;
        $this->namer = $namer;
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

    protected function applyNamer(MediaInterface $media)
    {
        if ($media->getName() !== null) {
            return false;
        }

        $name = $this->namer->getName($media->getFile());
        $media->setName($name);

        return true;
    }
}
