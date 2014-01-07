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

class Slider implements SliderInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var type
     */
    protected $slides;

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
     * Set name
     *
     * @param  string $name
     * @return Slider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param  string $description
     * @return Slider
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->slides = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add slides
     *
     * @param  SymEdit\Bundle\CoreBundle\Model\SlideInterface $slides
     * @return Slider
     */
    public function addSlide(SlideInterface $slide)
    {
        $this->slides[] = $slide;

        return $this;
    }

    /**
     * Remove slides
     *
     * @param SymEdit\Bundle\CoreBundle\Model\SlideInterface $slides
     */
    public function removeSlide(SlideInterface $slide)
    {
        $this->slides->removeElement($slide);
    }

    /**
     * Get slides
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSlides()
    {
        return $this->slides;
    }
}
