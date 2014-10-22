<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests;

use SymEdit\Bundle\CoreBundle\SymEditBundle;
use Symfony\Component\Yaml\Exception\RuntimeException;

class SymEditBundleTest extends TestCase
{
    /**
     * @expectedException RuntimeException
     */
    public function testMissingKernel()
    {
        $bundle = new SymEditBundle();
    }
}
