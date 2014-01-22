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

use SymEdit\Bundle\MediaBundle\Model\ImageInterface;

interface SlideInterface
{
    public function getId();

    public function setCaption($caption);
    public function getCaption();

    public function setSlider(SliderInterface $slider);
    public function getSlider();

    public function setImage(ImageInterface $image);
    public function getImage();

    public function setPosition($position);
    public function getPosition();
}
