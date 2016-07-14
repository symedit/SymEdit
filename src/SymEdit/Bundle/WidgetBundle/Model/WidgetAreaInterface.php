<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\ResourceInterface;

interface WidgetAreaInterface extends ResourceInterface
{
    public function getId();

    /**
     * @return string Area slug
     */
    public function getArea();

    /**
     * Set area slug.
     *
     * @param string $area
     */
    public function setArea($area);

    /**
     * @param string $description
     */
    public function setDescription($description);

    /**
     * @return string Description
     */
    public function getDescription();

    /**
     * @param WidgetInterface $widget
     */
    public function addWidget(WidgetInterface $widget);

    /**
     * @param WidgetInterface $widget
     */
    public function removeWidget(WidgetInterface $widget);

    /**
     * @return WidgetInterface
     */
    public function getWidgets();

    /**
     * @param ArrayCollection $widgets
     *
     * @return WidgetAreaInterface
     */
    public function setWidgets(ArrayCollection $widgets);
}
