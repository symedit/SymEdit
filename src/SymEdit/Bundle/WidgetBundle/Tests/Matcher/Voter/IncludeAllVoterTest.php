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

use SymEdit\Bundle\WidgetBundle\Matcher\Voter\IncludeAllVoter;
use SymEdit\Bundle\WidgetBundle\Model\Widget;
use SymEdit\Bundle\WidgetBundle\Tests\TestCase;

class IncludeAllVoterTest extends TestCase
{
    public function testIsVisible()
    {
        $voter = new IncludeAllVoter();
        $widget = $this->getMockForAbstractClass('SymEdit\Bundle\WidgetBundle\Model\WidgetInterface');
        $widget->expects($this->once())
               ->method('getVisibility')
               ->will($this->returnValue(Widget::INCLUDE_ALL));

        $this->assertTrue($voter->isVisible($widget));
    }
}
