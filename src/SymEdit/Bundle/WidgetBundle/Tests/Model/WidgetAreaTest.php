<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use SymEdit\Bundle\WidgetBundle\Model\Widget;
use SymEdit\Bundle\WidgetBundle\Model\WidgetArea;
use SymEdit\Bundle\WidgetBundle\Tests\TestCase;

class WidgetAreaTest extends TestCase
{
    public function testId()
    {
        $widgetArea = $this->getWidgetArea();
        $this->assertNull($widgetArea->getId());
    }

    public function testArea()
    {
        $widgetArea = $this->getWidgetArea();
        $this->assertNull($widgetArea->getArea());

        $widgetArea->setArea('foo');
        $this->assertEquals('foo', $widgetArea->getArea());
    }

    public function testDescription()
    {
        $widgetArea = $this->getWidgetArea();
        $this->assertNull($widgetArea->getDescription());

        $widgetArea->setDescription('foo.bar');
        $this->assertEquals('foo.bar', $widgetArea->getDescription());
    }

    public function testWidget()
    {
        $widgetArea = $this->getWidgetArea();
        $this->assertCount(0, $widgetArea->getWidgets());

        $widget1 = new Widget();
        $widget2 = new Widget();
        $widget3 = new Widget();

        $widgets = new ArrayCollection([$widget1, $widget2]);
        $widgetArea->setWidgets($widgets);
        $this->assertEquals($widgets, $widgetArea->getWidgets());

        // Check to make sure widgets were assigned this widget area
        foreach ($widgets as $widget) {
            $this->assertEquals($widgetArea, $widget->getArea());
        }

        // Test removal
        $widgetArea->removeWidget($widget1);
        $widgets->removeElement($widget1);
        $this->assertEquals($widgets, $widgetArea->getWidgets());

        // Again
        $widgetArea->removeWidget($widget1);
        $this->assertEquals($widgets, $widgetArea->getWidgets());

        // Add again
        $widgetArea->addWidget($widget3);
        $widgets->add($widget3);
        $this->assertEquals($widgets, $widgetArea->getWidgets());

        // Check area again for add
        $this->assertEquals($widgetArea, $widget3->getArea());
    }

    protected function getWidgetArea()
    {
        return new WidgetArea();
    }
}
