<?php

namespace Isometriks\Bundle\SymEditBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Isometriks\Bundle\SymEditBundle\Model\Widget; 

class LoadWidgetData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface 
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /**
         * Create sidebar
         */
        $sidebar = $this->getManager()->createWidgetArea(); 
        $sidebar->setArea('sidebar'); 
        $sidebar->setDescription('Sidebar Widget Area'); 
        
        /**
         * Fetch Blog Page
         */
        $blog = $this->getReference('page-blog');
        
        /**
         * Add Categories to Blog
         */
        $categories = $this->getManager()->createWidget('blog_categories'); 
        $categories->setName('blog_categories')
                   ->setTitle('Blog Categories')
                   ->setVisibility(Widget::INCLUDE_ONLY)
                   ->addAssoc($blog->getId()); 
        
        /**
         * Add Recent Posts to Blog 
         */
        $recent = $this->getManager()->createWidget('blog_recent_posts'); 
        $recent->setName('blog_recent_posts')
               ->setTitle('Recent Posts')
               ->setVisibility(Widget::INCLUDE_ONLY) 
               ->addAssoc($blog->getId());  

        /**
         * Add Widgets to Sidebar
         */
        $sidebar->addWidget($categories); 
        $sidebar->addWidget($recent); 
        
        $this->getManager()->saveWidgetArea($sidebar);
        
        $this->addReference('widgetarea-sidebar', $sidebar); 
        $this->addReference('widget-blog-categories', $categories); 
        $this->addReference('widget-blog-recent-posts', $recent);
        
        
        /**
         * Add Footer Area
         */
        $footer = $this->getManager()->createWidgetArea(); 
        $footer->setArea('footer'); 
        $footer->setDescription('Footer Widget Area'); 
        
        $contact = $this->getManager()->createWidget('contact_info'); 
        $contact->setName('contact_info')
                ->setTitle('Contact Information')
                ->setVisibility(Widget::INCLUDE_ALL); 
        
        $about = $this->getManager()->createWidget('html'); 
        $about->setName('about')
              ->setTitle('About Us')
              ->setVisibility(Widget::INCLUDE_ALL)
              ->setOption('html', '<p>This is all about our company...</p>'); 
        
        /**
         * Add Widgets to footer
         */
        $footer->addWidget($contact); 
        $footer->addWidget($about); 
        
        $this->getManager()->saveWidgetArea($footer); 
    }
    
    /**
     * @return \Isometriks\Bundle\SymEditBundle\Widget\WidgetManager
     */
    private function getManager()
    {
        return $this->container->get('isometriks_sym_edit.widget.manager'); 
    }

    public function getOrder()
    {
        return 25;
    }
}