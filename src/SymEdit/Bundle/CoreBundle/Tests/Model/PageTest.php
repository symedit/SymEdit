<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\Model;

use SymEdit\Bundle\CoreBundle\Model\Page;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\Page
     */
    protected function createPage()
    {
        return new Page();
    }

    public function testRouteName()
    {
        $page = $this->getMockBuilder(get_class($this->createPage()))
            ->setMethods(['getId'])
            ->getMock()
        ;

        $page
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(38))
        ;

        $this->assertEquals('page/38', $page->getRoute());
    }

    public function testActive()
    {
        $parent = $this->createPage();
        $child = $this->createPage();

        $parent->addChildren($child);
        $child->setActive(true, true);

        $this->assertTrue($parent->getActive());
    }
}
