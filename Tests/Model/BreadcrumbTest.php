<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Model; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Model\Breadcrumbs; 

class BreadcrumbTest extends TestCase
{
    private $breadcrumbs; 
    
    public function setUp()
    {
        $this->breadcrumbs = new Breadcrumbs(); 
        $this->breadcrumbs->push('Home', 'homepage'); 
        $this->breadcrumbs->push('Controller', 'controller', array(
            'val10' => 10, 
        )); 
    }
    
    protected function assertBreadcrumbCount($num)
    {
        $this->assertEquals($num, count($this->breadcrumbs)); 
    }
    
    /**
     * Test initial count
     */
    public function testBreadcrumbs()
    {
        /**
         * Test initial count
         */
        $this->assertBreadcrumbCount(2);  

        /**
         * Test unshift to add to beginning
         */
        $this->breadcrumbs->unshift('First', 'first'); 
        $crumbs = $this->breadcrumbs->all(); 
        
        $this->assertEquals('First', $crumbs[0]['title']);
        
        $this->assertBreadcrumbCount(3); 

        /**
         * Test popping
         */
        $popped = $this->breadcrumbs->pop(); 
        
        $this->assertEquals('Controller', $popped['title']); 

        $this->assertBreadcrumbCount(2); 
    }
}