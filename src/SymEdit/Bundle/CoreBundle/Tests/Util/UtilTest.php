<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\Util; 

use SymEdit\Bundle\CoreBundle\Tests\TestCase; 
use SymEdit\Bundle\CoreBundle\Util\Util; 

class UtilTest extends TestCase
{
    public function testSlugify()
    {
        $simple = array(
            'test space' => 'test-space', 
            'test two space' => 'test-two-space', 
            'test  two  spaces' => 'test-two-spaces', 
        );
        
        foreach($simple as $string => $expected){
            $this->assertEquals($expected, Util::slugify($string)); 
        }
    }    
}