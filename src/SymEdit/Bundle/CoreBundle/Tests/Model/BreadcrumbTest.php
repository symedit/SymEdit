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

use SymEdit\Bundle\CoreBundle\Model\Breadcrumbs;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;

class BreadcrumbTest extends TestCase
{
    private $breadcrumbs;

    public function setUp()
    {
        $this->breadcrumbs = new Breadcrumbs();
        $this->breadcrumbs->push('Home', 'homepage');
        $this->breadcrumbs->push('Controller', 'controller', [
            'val10' => 10,
        ]);
    }

    protected function assertBreadcrumbCount($num)
    {
        $this->assertEquals($num, count($this->breadcrumbs));
    }

    /**
     * Test initial count.
     */
    public function testBreadcrumbs()
    {
        /*
         * Test initial count
         */
        $this->assertBreadcrumbCount(2);

        /*
         * Test unshift to add to beginning
         */
        $this->breadcrumbs->unshift('First', 'first');
        $crumbs = $this->breadcrumbs->all();

        $this->assertEquals('First', $crumbs[0]['title']);

        $this->assertBreadcrumbCount(3);

        /*
         * Test popping
         */
        $popped = $this->breadcrumbs->pop();

        $this->assertEquals('Controller', $popped['title']);

        $this->assertBreadcrumbCount(2);
    }
}
