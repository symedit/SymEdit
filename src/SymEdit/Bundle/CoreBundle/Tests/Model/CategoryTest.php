<?php

namespace SymEdit\Bundle\CoreBundle\Test\Model; 

use SymEdit\Bundle\CoreBundle\Tests\TestCase; 
use SymEdit\Bundle\CoreBundle\Model\Category; 

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
        return $this->getMockForAbstractClass('SymEdit\Bundle\CoreBundle\Model\Category'); 
    }    
}