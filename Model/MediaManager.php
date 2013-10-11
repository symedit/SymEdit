<?php

namespace Isometriks\Bundle\MediaBundle\Model;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

abstract class MediaManager implements MediaManagerInterface
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return MediaInterface $file
     */
    public function createMedia()
    {
        $class = $this->getClass();

        return new $class;
    }


}