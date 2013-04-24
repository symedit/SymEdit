<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Entity; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Entity\Image; 
use Isometriks\Bundle\SymEditBundle\Entity\Post; 

class PostTest extends TestCase
{
    public function testImageSlug()
    {
        $image = $this->getMock('Isometriks\\Bundle\\SymEditBundle\\Entity\\Image', array('hasFile')); 
        $image->expects($this->any())
              ->method('hasFile')
              ->will($this->returnValue(true)); 
                
        $post = new Post(); 
        $post->setTitle('test post title'); 
        $post->setImage($image); 
        
        $this->assertEquals('test-post-title', $image->getName()); 
    }
}