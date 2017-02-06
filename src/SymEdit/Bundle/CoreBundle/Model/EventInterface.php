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

use SymEdit\Bundle\EventsBundle\Model\EventInterface as BaseEventInterface;
use SymEdit\Bundle\MediaBundle\Model\FileInterface;
use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

interface EventInterface extends BaseEventInterface, SeoAbleInterface
{
    public function getImage();

    public function setImage(ImageInterface $image = null);

    public function getFile();

    public function setFile(FileInterface $file = null);
}
