<?php

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
