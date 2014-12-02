<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Test;

use SymEdit\Bundle\WidgetBundle\Widget\Strategy\WidgetStrategyInterface;

abstract class WidgetStrategyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return WidgetStrategyInterface Get the strategy to test
     */
    abstract protected function createStrategy();

    abstract protected function getStrategyName();

    abstract protected function getStrategyDescription();

    abstract protected function getDefaultOptions();

    protected function createWidget()
    {
        return $this->getMockForAbstractClass('SymEdit\Bundle\WidgetBundle\Model\WidgetInterface');
    }

    protected function getFormBuilder()
    {
        return $this->getMockForAbstractClass('Symfony\Component\Form\FormBuilderInterface');
    }

    public function testName()
    {
        $strategy = $this->createStrategy();
        $this->assertEquals($this->getStrategyName(), $strategy->getName());
    }

    public function testDescription()
    {
        $strategy = $this->createStrategy();
        $this->assertEquals($this->getStrategyDescription(), $strategy->getDescription());
    }

    public function testDefaultOptions()
    {
        $strategy = $this->createStrategy();
        $widget = $this->createWidget();

        $widget->expects($this->once())
               ->method('setOptions')
               ->with($this->equalTo($this->getDefaultOptions()));

        $strategy->setDefaultOptions($widget);
    }

    public function testBuildForm()
    {
        $strategy = $this->createStrategy();
        $builder = $this->getFormBuilder();

        $strategy->buildForm($builder);
    }
}
