<?php

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