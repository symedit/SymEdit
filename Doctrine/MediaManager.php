<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine;

use Isometriks\Bundle\MediaBundle\Model\MediaManager as BaseMediaManager;
use Doctrine\Common\Persistence\ObjectManager;

class MediaManager extends BaseMediaManager
{
    protected $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
}