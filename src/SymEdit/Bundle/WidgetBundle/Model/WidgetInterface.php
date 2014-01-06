<?php

namespace SymEdit\Bundle\WidgetBundle\Model;

use SymEdit\Bundle\WidgetBundle\Widget\Strategy\WidgetStrategyInterface;

interface WidgetInterface
{
    public function getId();

    /**
     * @return WidgetInterface
     * @param  string          $name
     */
    public function setName($name);
    public function getName();

    /**
     * @return WidgetInterface
     * @param  type            $title
     */
    public function setTitle($title);
    public function getTitle();

    public function getArea();

    /**
     * @return WidgetInterface
     * @param  \SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface $area
     */
    public function setArea(WidgetAreaInterface $area);

    /**
     * @return WidgetInterface
     * @param  array           $options
     */
    public function setOptions(array $options);

    /**
     * @return WidgetInterface
     * @param  string          $option
     * @param  mixed           $value
     */
    public function setOption($option, $value);

    /**
     * Get all options
     *
     * @return array $options
     */
    public function getOptions();

    /**
     * Get an option's value
     *
     * @param  string $option
     * @return mixed  $value
     */
    public function getOption($option);

    /**
     * Check if option exists
     *
     * @param  string  $option
     * @return boolean
     */
    public function hasOption($option);

    /**
     * @return WidgetInterface
     * @param  type            $strategyName
     */
    public function setStrategyName($strategyName);

    /**
     * Get the strategy name
     *
     * @return string $strategyName
     */
    public function getStrategyName();

    /**
     * @return WidgetStrategyInterface $strategy
     */
    public function getStrategy();

    /**
     * @return WidgetInterface
     * @param  \SymEdit\Bundle\WidgetBundle\Widget\Strategy\WidgetStrategyInterface $strategy
     */
    public function setStrategy(WidgetStrategyInterface $strategy);

    /**
     * @return WidgetInterface
     * @param  integer         $visibility
     */
    public function setVisibility($visibility);

    /**
     * Gets the visibility of the widget
     *
     * @return integer $visibility
     */
    public function getVisibility();

    /**
     * Checks visibility against page
     *
     * @param array $strings Strings to check for visibility
     */
    public function isVisible(array $strings);

    /**
     * @return WidgetInterface
     * @param  array           $assoc
     */
    public function setAssoc(array $assoc);

    /**
     * @return WidgetInterface
     * @param  string          $assoc
     */
    public function addAssoc($assoc);

    /**
     * @return WidgetInterface
     * @param  string          $assoc
     */
    public function removeAssoc($assoc);

    /**
     * Get all associations
     *
     * @return array $assoc
     */
    public function getAssoc();

    /**
     * Check for association
     *
     * @param array $strings Strings to check
     */
    public function hasAssoc(array $strings);

    public function getWidgetOrder();

    public function setWidgetOrder($widgetOrder);
}
