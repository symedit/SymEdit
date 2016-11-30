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

use SymEdit\Bundle\BlogBundle\Model\Category;
use SymEdit\Bundle\BlogBundle\Model\Post;
use SymEdit\Bundle\BlogBundle\Tests\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class PostTest extends TestCase
{
    /**
     * @return Post
     */
    protected function getPost()
    {
        return new Post();
    }

    public function testTitle()
    {
        $post = $this->getPost();
        $this->assertNull($post->getTitle());

        $post->setTitle('foo');
        $this->assertEquals('foo', $post->getTitle());
    }

    public function testSlug()
    {
        $post = $this->getPost();
        $this->assertNull($post->getSlug());

        $post->setSlug('bar');
        $this->assertEquals('bar', $post->getSlug());
    }

    public function testContent()
    {
        $post = $this->getPost();
        $this->assertNull($post->getContent());

        $post->setContent('foo bar');
        $this->assertEquals('foo bar', $post->getContent());
    }

    public function testSummary()
    {
        $post = $this->getPost();
        $this->assertNull($post->getSummary());

        $post->setSummary('foo bar');
        $this->assertEquals('foo bar', $post->getSummary());
    }

    public function testCategories()
    {
        $post = $this->getPost();
        $category = new Category();

        // Add
        $post->addCategory($category);
        $this->assertTrue($post->getCategories()->contains($category));

        // Remove
        $post->removeCategory($category);
        $this->assertFalse($post->getCategories()->contains($category));
    }

    public function testStatus()
    {
        $post = $this->getPost();
        $this->assertEquals(Post::DRAFT, $post->getStatus());

        $post->setStatus(Post::PUBLISHED);
        $this->assertEquals(Post::PUBLISHED, $post->getStatus());
    }

    public function testUpdated()
    {
        $post = $this->getPost();
        $updated = new \DateTime();
        $updated->modify('+1 second');

        // The time it is initalized with should be less than one we just created
        $this->assertLessThan($updated, $post->getUpdatedAt());

        $post->setUpdatedAt($updated);
        $this->assertEquals($updated, $post->getUpdatedAt());
    }

    public function testCreated()
    {
        $post = $this->getPost();
        $updated = new \DateTime();
        $updated->modify('+1 second');

        // The time it is initalized with should be less than one we just created
        $this->assertLessThan($updated, $post->getCreatedAt());

        $post->setCreatedAt($updated);
        $this->assertEquals($updated, $post->getCreatedAt());
    }

    public function testPublishedAt()
    {
        $post = $this->getPost();
        $updated = new \DateTime();
        $updated->modify('+1 second');

        // We are going with setting published in constructor
        // because the doctrine timestampable doesn't trigger the "change"
        // to published if you create it with published. It should be using
        // the status to determine if it's published anyway
        $this->assertNotNull($post->getPublishedAt());
        $this->assertLessThan($updated, $post->getPublishedAt());

        $post->setPublishedAt($updated);
        $this->assertEquals($updated, $post->getPublishedAt());
    }

    public function testPublished()
    {
        $post = $this->getPost();
        $this->assertFalse($post->isPublished());

        $post->setStatus(Post::PUBLISHED);
        $this->assertTrue($post->isPublished());
    }

    public function testAuthor()
    {
        $post = $this->getPost();
        $this->assertNull($post->getAuthor());

        $author = $this->getMockBuilder(UserInterface::class)
            ->getMock()
        ;

        $post->setAuthor($author);
        $this->assertEquals($author, $post->getAuthor());
    }
}
