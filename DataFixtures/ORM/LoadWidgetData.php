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
         * Add Recent Posts to Blog 
         */
        $blog = $this->getReference('page-blog'); 
        
        $recent = $this->getManager()->createWidget(); 
        $recent->setStrategyName('blog_recent_posts');
        $recent->setName('blog_recent_posts'); 
        $recent->setOption('max', 3); 
        $recent->setTitle('Recent Posts'); 
        $recent->setVisibility(Widget::INCLUDE_ONLY); 
        $recent->setAssoc(array(
            $blog->getId(), 
        ));
        
        /**
         * Add Widget to Sidebar
         */
        $sidebar->addWidget($recent); 
        
        $this->getManager()->saveWidgetArea($sidebar);
        
        $this->addReference('widgetarea-sidebar', $sidebar); 
        $this->addReference('widget-recent-posts', $recent);
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