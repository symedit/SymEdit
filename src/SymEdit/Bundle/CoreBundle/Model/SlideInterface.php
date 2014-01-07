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

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

interface SlideInterface
{
    public function getId();

    public function setCaption($caption);
    public function getCaption();

    public function setSlider(SliderInterface $slider);
    public function getSlider();

    public function setImage(MediaInterface $image);
    public function getImage();

    public function setPosition($position);
    public function getPosition();
}
