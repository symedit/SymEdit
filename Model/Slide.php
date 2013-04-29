<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

abstract class Slide implements SlideInterface
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
     * @var Image
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
     * @param string $caption
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
     * @param Isometriks\Bundle\SymEditBundle\Model\SliderInterface $slider
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
     * @return Isometriks\Bundle\SymEditBundle\Model\SliderInterface
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Set image
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Image $image
     * @return Slide
     */
    public function setImage(\Isometriks\Bundle\SymEditBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return Isometriks\Bundle\SymEditBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set position
     *
     * @param string $position
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