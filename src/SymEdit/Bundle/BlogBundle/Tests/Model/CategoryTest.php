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
    protected function createPost($status = Post::DRAFT)
    {
        $post = new Post();
        $post->setStatus($status);

        return $post;
    }

    /**
     * @return Category
     */
    protected function getCategory()
    {
        $category = new Category();
        $category->setPosts(new ArrayCollection([
            $this->createPost(Post::PUBLISHED),
            $this->createPost(Post::DRAFT),
            $this->createPost(Post::PUBLISHED),
        ]));

        return $category;
    }

    public function testToString()
    {
        $category = $this->getCategory();
        $category->setTitle('foobar');
        $this->assertEquals('foobar', $category->__toString());
    }

    public function testGetSetName()
    {
        $category = $this->getCategory();
        $category->setName('foo');

        $this->assertEquals('foo', $category->getName());
    }

    public function testGetSetTitle()
    {
        $category = $this->getCategory();
        $category->setTitle('bar');

        $this->assertEquals('bar', $category->getTitle());
    }

    public function testGetSetSlug()
    {
        $category = $this->getCategory();
        $category->setSlug('any slug');

        $this->assertEquals('any slug', $category->getSlug());
    }

    public function testGetSetLevel()
    {
        $category = $this->getCategory();
        $category->setLevel(5);

        $this->assertEquals(5, $category->getLevel());
    }

    public function testGetRoot()
    {
        $category = $this->getCategory();
        $parent = $this->getCategory();

        // No parent, should be root
        $this->assertTrue($category->getRoot());

        // Should no longer be root
        $category->setParent($parent);
        $this->assertFalse($category->getRoot());
    }

    public function testChildren()
    {
        $category = $this->getCategory();
        $child = new Category();

        // Add Child
        $category->addChildren($child);
        $this->assertEquals(1, count($category->getChildren()));

        // Remove Child
        $category->removeChildren($child);
        $this->assertEquals(0, count($category->getChildren()));
    }

    public function testAddPost()
    {
        $category = $this->getCategory();
        $post = $this->createPost();

        $category->addPost($post);

        $this->assertTrue($category->getPosts()->contains($post));
    }

    public function testRemovePost()
    {
        $category = $this->getCategory();
        $post = $this->createPost();

        $category->addPost($post);
        $category->removePost($post);

        $this->assertFalse($category->getPosts()->contains($post));
    }

    public function testGetPosts()
    {
        $this->assertEquals(3, count($this->getCategory()->getPosts()));
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
