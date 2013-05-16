<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Model; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Model\Page; 

class PageTest extends TestCase
{
    public function testPageTree()
    {
        $root = $this->getPage(); 
        $root->setRoot(true); 
        
        $home = $this->getPage(); 
        $home->setHomepage(true); 
        
        $about = $this->getPage(); 
        $about->setName('about-us'); 
        
        $team = $this->getPage(); 
        $team->setName('meet-the-team'); 
        
        // Connect them
        $root->addChildren($home); 
        $root->addChildren($about); 
        $about->addChildren($team); 
        
        // Refresh the tree
        $root->setUpdated(); 
        
        // About Page
        $this->assertEquals('/about-us', $about->getPath()); 
        $this->assertEquals(1, $about->getLevel()); 
        
        // Team Page
        $this->assertEquals('/about-us/meet-the-team', $team->getPath()); 
        $this->assertEquals(2, $team->getLevel()); 
        $this->assertEquals('page_about_us_meet_the_team', $team->getRoute()); 
    }
    
    /**
     * @return Page
     */
    protected function getPage()
    {
        return $this->getMockForAbstractClass('Isometriks\Bundle\SymEditBundle\Model\Page'); 
    }
}