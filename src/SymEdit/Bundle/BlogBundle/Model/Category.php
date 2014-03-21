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
     * @var Array of CategoryInterface
     */
    protected $children;

    /**
     * @var ArrayCollection
     */
    protected $posts;

    /**
     * @var array $seo
     */
    protected $seo;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string   $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param  string   $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param  string   $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function getRoot()
    {
        return $this->getParent() === null;
    }

    /**
     * Set parent
     *
     * @param  CategoryInterface $parent
     * @return CategoryInterface
     */
    public function setParent(CategoryInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return CategoryInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get depth of the category
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set the depth of the category
     *
     * @param integer $level
     * @return Category
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Add children
     *
     * @param  CategoryInterface $children
     * @return Category
     */
    public function addChildren(CategoryInterface $children)
    {
        $children->setParent($this);
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param CategoryInterface $children
     */
    public function removeChildren(CategoryInterface $children)
    {
        $this->children->removeElement($children);
    }

    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set seo
     *
     * @param  array $seo
     * @return Post
     */
    public function setSeo(array $seo = array())
    {
        $this->seo = $seo;

        return $this;
    }

    /**
     * Get seo
     *
     * @return array
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Add posts
     *
     * @param  PostInterface     $posts
     * @return CategoryInterface
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param PostInterface $posts
     */
    public function removePost(Post $post)
    {
        $this->posts->removeElement($post);
    }

    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    public function getPublishedPosts()
    {
        return $this->posts->filter(function (PostInterface $post) {
            return $post->isPublished();
        });
    }

    public function getTotal()
    {
        return $this->getPublishedPosts()->count();
    }
}
