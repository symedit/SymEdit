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

interface WidgetInterface
{
    const INCLUDE_ALL = 0;
    const INCLUDE_ONLY = 1;
    const EXCLUDE_ONLY = 2;

    public function getId();

    /**
     * @param string $name
     *
     * @return WidgetInterface
     */
    public function setName($name);

    /**
     * @return string $name
     */
    public function getName();

    /**
     * @param string $title
     *
     * @return WidgetInterface
     */
    public function setTitle($title);

    /**
     * @return string $title
     */
    public function getTitle();

    /**
     * Get the widget area.
     *
     * @return WidgetAreaInterface $area
     */
    public function getArea();

    /**
     * @param WidgetAreaInterface $area
     *
     * @return WidgetInterface
     */
    public function setArea(WidgetAreaInterface $area);

    /**
     * @param array $options
     *
     * @return WidgetInterface
     */
    public function setOptions(array $options);

    /**
     * @return WidgetInterface
     *
     * @param string $option
     * @param mixed  $value
     */
    public function setOption($option, $value);

    /**
     * Get all options.
     *
     * @return array $options
     */
    public function getOptions();

    /**
     * Get an option's value.
     *
     * @param string $option
     *
     * @return mixed $value
     */
    public function getOption($option);

    /**
     * Check if option exists.
     *
     * @param string $option
     *
     * @return bool
     */
    public function hasOption($option);

    /**
     * @return WidgetInterface
     *
     * @param string $strategyName
     */
    public function setStrategyName($strategyName);

    /**
     * Get the strategy name.
     *
     * @return string $strategyName
     */
    public function getStrategyName();

    /**
     * @return WidgetInterface
     *
     * @param int $visibility
     */
    public function setVisibility($visibility);

    /**
     * Gets the visibility of the widget.
     *
     * @return int $visibility
     */
    public function getVisibility();

    /**
     * Get last updated date.
     *
     * @return \DateTime Last updated date.
     */
    public function getUpdatedAt();

    /**
     * Get created at date.
     *
     * @return \DateTime Get date created.
     */
    public function getCreatedAt();

    /**
     * @return WidgetInterface
     *
     * @param array $assoc
     */
    public function setAssoc(array $assoc);

    /**
     * @return WidgetInterface
     *
     * @param string $assoc
     */
    public function addAssoc($assoc);

    /**
     * @return WidgetInterface
     *
     * @param string $assoc
     */
    public function removeAssoc($assoc);

    /**
     * Get all associations.
     *
     * @return array $assoc
     */
    public function getAssoc();

    public function getWidgetOrder();

    public function setWidgetOrder($widgetOrder);
}
