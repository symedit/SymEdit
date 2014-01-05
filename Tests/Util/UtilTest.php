<?php

namespace Isometriks\Bundle\SymEditBundle\Tests\Util; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Util\Util; 

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