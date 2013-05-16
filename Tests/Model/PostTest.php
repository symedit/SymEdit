<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Model; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Model\Post; 

class PostTest extends TestCase
{
    public function testImageSlug()
    {
        $image = $this->getMock('Isometriks\\Bundle\\SymEditBundle\\Entity\\Image', array('hasFile')); 
        $image->expects($this->any())
              ->method('hasFile')
              ->will($this->returnValue(true)); 
                
        $post = $this->getPost();
        $post->setTitle('test post title'); 
        $post->setImage($image); 
        
        $this->assertEquals('test-post-title', $image->getName()); 
    }
    
    /**
     * @return Post
     */
    protected function getPost()
    {
        return $this->getMockForAbstractClass('Isometriks\Bundle\SymEditBundle\Model\Post'); 
    }
}