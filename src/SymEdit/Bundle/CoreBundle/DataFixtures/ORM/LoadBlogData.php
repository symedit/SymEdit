<?php

namespace SymEdit\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use SymEdit\Bundle\CoreBundle\Model\Category;
use SymEdit\Bundle\CoreBundle\Model\Post; 

class LoadBlogData extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager)
    {
        // Create a general category
        $category_general = new Category(); 
        $category_general
            ->setName('general')
            ->setTitle('General');
        
        $manager->persist($category_general); 
        
        // Create a default post
        $post_default = new Post(); 
        $post_default
            ->setAuthor($this->getReference('user-admin'))
            ->setTitle('Hello World!')
            ->setStatus(Post::PUBLISHED)
            ->setContent('<p>Here is your first blog post! You will probably want to delete this.</p>');
        
        $manager->persist($post_default); 

        // Write them all
        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }

}