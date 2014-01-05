<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface SliderInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set name
     *
     * @param  string $name
     * @return Slider
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set description
     *
     * @param  string $description
     * @return Slider
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Add slides
     *
     * @param  Isometriks\Bundle\SymEditBundle\Model\SlideInterface $slides
     * @return Slider
     */
    public function addSlide(SlideInterface $slide);

    /**
     * Remove slides
     *
     * @param Isometriks\Bundle\SymEditBundle\Model\SlideInterface $slides
     */
    public function removeSlide(SlideInterface $slide);

    /**
     * Get slides
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSlides();
}
