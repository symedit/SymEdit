<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Entity; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Entity\Category; 

class CategoryTest extends TestCase
{
    public function testCategorySlug()
    {
        $parent = new Category(); 
        $parent->setName('parent-name'); 
        
        $child = new Category(); 
        $child->setName('child-name'); 
       
        $parent->addChildren($child); 
        $parent->setUpdated(); 
        
        $this->assertEquals('parent-name/child-name', $child->getSlug()); 
    }
}