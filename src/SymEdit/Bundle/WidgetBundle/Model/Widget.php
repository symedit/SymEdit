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

use Sylius\Component\Resource\Model\ResourceInterface;

class Widget implements WidgetInterface, ResourceInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string Widget Name
     */
    protected $name;

    /**
     * @var string Widget Title
     */
    protected $title;

    /**
     * @var WidgetAreaInterface Widget Area
     */
    protected $area;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $strategyName;

    /**
     * @var int
     */
    protected $visibility;

    /**
     * @var array
     */
    protected $assoc;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $widgetOrder;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->setOptions([]);
        $this->setVisibility(self::INCLUDE_ALL);
        $this->setAssoc([]);
        $this->setUpdatedAt(new \DateTime());
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setArea(WidgetAreaInterface $area)
    {
        $this->area = $area;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption($option)
    {
        if (!isset($this->options[$option])) {
            return;
        }

        return $this->options[$option];
    }

    public function hasOption($option)
    {
        return isset($this->options[$option]);
    }

    public function setStrategyName($strategyName)
    {
        $this->strategyName = $strategyName;

        return $this;
    }

    public function getStrategyName()
    {
        return $this->strategyName;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function setAssoc(array $assoc)
    {
        $this->assoc = $assoc;

        return $this;
    }

    public function addAssoc($assoc)
    {
        $this->assoc[] = $assoc;

        return $this;
    }

    public function removeAssoc($assoc)
    {
        foreach ($this->assoc as $key => $value) {
            if ($assoc == $value) {
                unset($this->assoc[$key]);
            }
        }

        /*
         * Reset array keys
         */
        $this->assoc = array_values($this->assoc);

        return $this;
    }

    public function getAssoc()
    {
        return $this->assoc;
    }

    /**
     * @return \DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return WidgetInterface $widget
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getWidgetOrder()
    {
        return $this->widgetOrder;
    }

    /**
     * @param int $widgetOrder
     *
     * @return Widget
     */
    public function setWidgetOrder($widgetOrder)
    {
        $this->widgetOrder = $widgetOrder;

        return $this;
    }
}
