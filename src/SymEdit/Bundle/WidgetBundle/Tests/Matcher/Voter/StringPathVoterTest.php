<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Tests\Matcher\Voter;

use SymEdit\Bundle\WidgetBundle\Matcher\Voter\StringPathVoter;
use SymEdit\Bundle\WidgetBundle\Model\Widget;
use SymEdit\Bundle\WidgetBundle\Tests\TestCase;

class StringPathVoterTest extends TestCase
{
    protected function createWidget()
    {
        return new Widget();
    }

    public function testConstruct()
    {
        $voter = new StringPathVoter('foo');
        $this->assertEquals('foo', $voter->getString());
    }

    public function testString()
    {
        $voter = new StringPathVoter('foo');
        $voter->setString('bar');
        $this->assertEquals('bar', $voter->getString());
    }

    /**
     * @dataProvider matchingPathsProvider
     */
    public function testIncludeOnly($association)
    {
        $voter = new StringPathVoter('/foo/bar');
        $widget = $this->createWidget();
        $widget->setVisibility(Widget::INCLUDE_ONLY);
        $widget->setAssoc([
            $association,
        ]);

        $this->assertTrue($voter->isVisible($widget));
    }

    /**
     * @dataProvider matchingPathsProvider
     */
    public function testExcludeOnly($association)
    {
        $voter = new StringPathVoter('/foo/bar');
        $widget = $this->createWidget();
        $widget->setVisibility(Widget::EXCLUDE_ONLY);
        $widget->setAssoc([
            $association,
        ]);

        $this->assertFalse($voter->isVisible($widget));
    }

    public function matchingPathsProvider()
    {
        return [
            ['/foo/bar/'],
            ['/foo/bar'],
            ['/foo/*/'],
            ['/foo/*'],
            ['/*/'],
            ['/*'],
            ['*'],
        ];
    }
}
