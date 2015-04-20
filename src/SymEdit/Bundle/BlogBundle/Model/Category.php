<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Category implements CategoryInterface
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $slug
     */
    protected $slug;

    /**
     * @var CategoryInterface
     */
    protected $parent;

    /**
     * @var integer
     */
    protected $level;

    /**
     * @var ArrayCollection
     */
    protected $children;

    /**
     * @var ArrayCollection
     */
    protected $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritDoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoot()
    {
        return $this->getParent() === null;
    }

    /**
     * {@inheritDoc}
     */
    public function setParent(CategoryInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritDoc}
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * {@inheritDoc}
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addChildren(CategoryInterface $children)
    {
        $children->setParent($this);
        $this->children[] = $children;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeChildren(CategoryInterface $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * {@inheritDoc}
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritDoc}
     */
    public function addPost(PostInterface $post)
    {
        $this->posts->add($post);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removePost(PostInterface $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * {@inheritDoc}
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * {@inheritDoc}
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * {@inheritDoc}
     */
    public function getPublishedPosts()
    {
        return $this->posts->filter(function (PostInterface $post) {
            return $post->isPublished();
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal()
    {
        return $this->getPublishedPosts()->count();
    }
}
