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

class Slide implements SlideInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $caption
     */
    protected $caption;

    /**
     * @var string $position
     */
    protected $position;

    /**
     * @var Slider
     */
    protected $slider;

    /**
     * @var MediaInterface
     */
    protected $image;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set caption
     *
     * @param  string $caption
     * @return Slide
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set slider
     *
     * @param  SymEdit\Bundle\CoreBundle\Model\SliderInterface $slider
     * @return Slide
     */
    public function setSlider(SliderInterface $slider = null)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return SymEdit\Bundle\CoreBundle\Model\SliderInterface
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Set image
     *
     * @param  MediaInterface $image
     * @return Slide
     */
    public function setImage(MediaInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return MediaInterface
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set position
     *
     * @param  string $position
     * @return Slide
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }
}
