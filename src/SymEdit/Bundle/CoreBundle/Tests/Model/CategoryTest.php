<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Model; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Model\Category; 

class CategoryTest extends TestCase
{
    public function testCategorySlug()
    {
        $parent = $this->getCategory(); 
        $parent->setName('parent-name'); 
        
        $child = $this->getCategory(); 
        $child->setName('child-name'); 
       
        $parent->addChildren($child); 
        $parent->setUpdated(); 
        
        $this->assertEquals('parent-name/child-name', $child->getSlug()); 
    }
    
    /**
     * @return Category
     */
    protected function getCategory()
    {
        return $this->getMockForAbstractClass('Isometriks\Bundle\SymEditBundle\Model\Category'); 
    }    
}