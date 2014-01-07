<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Test\Model; 

use SymEdit\Bundle\CoreBundle\Tests\TestCase; 
use SymEdit\Bundle\BlogBundle\Model\Category; 

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
        return $this->getMockForAbstractClass('SymEdit\Bundle\BlogBundle\Model\Category'); 
    }    
}