<?php

namespace SymEdit\Bundle\WidgetBundle\Tests\Model;

use SymEdit\Bundle\WidgetBundle\Model\Widget;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Tests\TestCase;

class WidgetTest extends TestCase
{
    public function testId()
    {
        $widget = $this->getWidget();
        $this->assertNull($widget->getId());
    }

    public function testName()
    {
        $widget = $this->getWidget();
        $this->assertNull($widget->getName());

        $widget->setName('foo');
        $this->assertEquals('foo', $widget->getName());
    }

    public function testTitle()
    {
        $widget = $this->getWidget();
        $this->assertNull($widget->getTitle());

        $widget->setTitle('bar');
        $this->assertEquals('bar', $widget->getTitle());
    }

    public function testVisibility()
    {
        $widget = $this->getWidget();
        $this->assertEquals(WidgetInterface::INCLUDE_ALL, $widget->getVisibility());

        $widget->setVisibility(WidgetInterface::EXCLUDE_ONLY);
        $this->assertEquals(WidgetInterface::EXCLUDE_ONLY, $widget->getVisibility());
    }

    public function testAssoc()
    {
        $widget = $this->getWidget();
        $this->assertEquals(array(), $widget->getAssoc());

        $assoc = array(
            '/', '/about',
        );

        $widget->setAssoc($assoc);
        $this->assertEquals($assoc, $widget->getAssoc());

        // Test Add
        $widget->addAssoc('/contact');
        $assoc[] = '/contact';
        $this->assertEquals($assoc, $widget->getAssoc());

        // Test Remove
        $widget->removeAssoc('/');
        unset($assoc[0]);
        $this->assertEquals(array_values($assoc), $widget->getAssoc());
    }

    public function testOrder()
    {
        $widget = $this->getWidget();
        $this->assertNull($widget->getWidgetOrder());

        $widget->setWidgetOrder(5);
        $this->assertEquals(5, $widget->getWidgetOrder());
    }

    public function testOptions()
    {
        $widget = $this->getWidget();
        $this->assertEquals(array(), $widget->getOptions());

        $options = array(
            'foo' => 'bar',
            'baz' => 'salts',
        );

        $widget->setOptions($options);
        $this->assertEquals($options, $widget->getOptions());

        // Check existence
        $this->assertTrue($widget->hasOption('foo'));
        $this->assertTrue($widget->hasOption('baz'));
        $this->assertFalse($widget->hasOption('test'));

        // Set individual option
        $widget->setOption('foo', 'buzz');
        $this->assertEquals('buzz', $widget->getOption('foo'));
    }

    protected function getWidget()
    {
        return new Widget();
    }
}
