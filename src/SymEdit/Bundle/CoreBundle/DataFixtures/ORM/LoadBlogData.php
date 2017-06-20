<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\CoreBundle\DataFixtures\AbstractFixture;
use SymEdit\Bundle\CoreBundle\Model\CategoryInterface;
use SymEdit\Bundle\CoreBundle\Model\Post;

class LoadBlogData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Create a general category
        $category_general = $this->createCategory();
        $category_general
            ->setName('general')
            ->setTitle('General');

        $manager->persist($category_general);

        // Create a default post
        $post_default = $this->createPost();
        $post_default
            ->setAuthor($this->getReference('user-admin'))
            ->setTitle('Hello World!')
            ->setStatus(Post::PUBLISHED)
            ->setContent('<p>Here is your first blog post! You will probably want to delete this.</p>')
            ->addCategory($category_general)
            ->setSeo([
                'title' => 'SEO Title',
                'description' => 'SEO Description',
            ])
        ;

        $manager->persist($post_default);

        // Write them all
        $manager->flush();
    }

    /**
     * @return CategoryInterface
     */
    protected function createCategory()
    {
        return $this->getFactory('category')->createNew();
    }

    protected function createPost()
    {
        return $this->getFactory('post')->createNew();
    }

    public function getOrder()
    {
        return 20;
    }
}
