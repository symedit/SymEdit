<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use SymEdit\Bundle\BlogBundle\Model\Category;
use SymEdit\Bundle\BlogBundle\Model\Post;
use SymEdit\Bundle\BlogBundle\Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * @return Category
     */
    protected function getCategory()
    {
        $category = new Category();
        $category->setPosts(new ArrayCollection(array(
            (new Post())->setStatus(Post::PUBLISHED),
            (new Post())->setStatus(Post::DRAFT),
            (new Post())->setStatus(Post::PUBLISHED),
        )));

        return $category;
    }

    public function testGetPublishedPosts()
    {
        foreach ($this->getCategory()->getPublishedPosts() as $post) {
            $this->assertTrue($post->isPublished());
        }
    }

    public function testGetTotal()
    {
        $this->assertEquals(2, $this->getCategory()->getTotal());
    }
}