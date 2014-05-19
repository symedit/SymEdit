<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Test\Model;

use SymEdit\Bundle\CoreBundle\Tests\TestCase;
use SymEdit\Bundle\CoreBundle\Model\Page;

class PageTest extends TestCase
{
    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\Page
     */
    protected function createPage()
    {
        return new Page();
    }

    public function testHomepageRoute()
    {
        $homepage = $this->createPage()
                        ->setHomepage(true);

        $this->assertEquals('homepage', $homepage->getRoute());
    }

    public function testRouteName()
    {
        $page = $this->getMock(get_class($this->createPage()), array('getId'));
        $page->expects($this->any())
             ->method('getId')
             ->will($this->returnValue(38));

        $this->assertEquals('page_38', $page->getRoute());
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
