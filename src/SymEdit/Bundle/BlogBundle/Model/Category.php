<?php

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
     * PrePersist
     */
    public function fixSlug()
    {
        $slug = $this->getParent() ? $this->getParent()->getSlug() .'/' . $this->getName() : $this->getName();
        $this->setSlug($slug);
    }

    public function setUpdated()
    {
        // Set the slug to be parent slug/post name
        $this->fixSlug();

        // In case this category's slug has changed, let's fix the children too
        foreach ($this->getChildren() as $child) {
            $child->setUpdated();
        }
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
        return $this->posts->count();
    }
}
