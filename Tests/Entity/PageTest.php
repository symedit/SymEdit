<?php

namespace Isometriks\Bundle\SymEditBundle\Test\Entity; 

use Isometriks\Bundle\SymEditBundle\Tests\TestCase; 
use Isometriks\Bundle\SymEditBundle\Entity\Page; 

class PageTest extends TestCase
{
    public function testImageSlug()
    {
        $root = new Page(); 
        $root->setRoot(true); 
        
        $home = new Page(); 
        $home->setHomepage(true); 
        
        $about = new Page(); 
        $about->setName('about-us'); 
        
        $team = new Page(); 
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
}