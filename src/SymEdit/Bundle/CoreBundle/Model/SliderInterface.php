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
     * @param  SymEdit\Bundle\CoreBundle\Model\SlideInterface $slides
     * @return Slider
     */
    public function addSlide(SlideInterface $slide);

    /**
     * Remove slides
     *
     * @param SymEdit\Bundle\CoreBundle\Model\SlideInterface $slides
     */
    public function removeSlide(SlideInterface $slide);

    /**
     * Get slides
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSlides();
}
