<?php

namespace SymEdit\Bundle\WidgetBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

interface WidgetAreaInterface
{
    public function getId();

    /**
     * @return string Area slug
     */
    public function getArea();

    /**
     * Set area slug
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
     * @param  \Doctrine\Common\Collections\ArrayCollection $widgets
     * @return WidgetAreaInterface
     */
    public function setWidgets(ArrayCollection $widgets);
}
