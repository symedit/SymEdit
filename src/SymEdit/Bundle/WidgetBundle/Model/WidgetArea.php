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

class WidgetArea implements WidgetAreaInterface
{
    protected $id;
    protected $area;
    protected $description;
    protected $widgets;

    public function __construct()
    {
        $this->widgets = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getWidgets()
    {
        return $this->widgets;
    }

    public function addWidget(WidgetInterface $widget)
    {
        $widget->setArea($this);
        $this->widgets->add($widget);

        return $this;
    }

    public function removeWidget(WidgetInterface $widget)
    {
        $this->widgets->removeElement($widget);

        return $this;
    }

    public function setWidgets(ArrayCollection $widgets)
    {
        foreach ($widgets as $widget) {
            $widget->setArea($this);
        }

        $this->widgets = $widgets;

        return $this;
    }
}
