<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\EventsBundle\Model\Event as BaseEvent;
use SymEdit\Bundle\MediaBundle\Model\FileInterface;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;

class Event extends BaseEvent implements EventInterface
{
    protected $seo;
    protected $image;
    protected $file;

    public function setSeo(array $seo = [])
    {
        $this->seo = $seo;

        return $this;
    }

    public function getSeo()
    {
        return $this->seo;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(ImageInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(FileInterface $file = null)
    {
        $this->file = $file;

        return $this;
    }
}
