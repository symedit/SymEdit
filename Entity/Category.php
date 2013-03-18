<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Isometriks\Bundle\SymEditBundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Isometriks\Bundle\SymEditBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"persist","remove"})
     */
    private $children;
    
    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="categories")
     */
    private $posts; 
    
    /**
     * @var array $seo
     *
     * @ORM\Column(name="seo", type="json_array", nullable=true)
     */
    private $seo;
    
    
    public function __toString()
    {
        return $this->getSlug();
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
     * @param string $name
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
     * @param string $title
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
     * @param string $slug
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
     * @ORM\PrePersist
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
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set parent
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\Isometriks\Bundle\SymEditBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return Isometriks\Bundle\SymEditBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Category $children
     * @return Category
     */
    public function addChildren(\Isometriks\Bundle\SymEditBundle\Entity\Category $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Category $children
     */
    public function removeChildren(\Isometriks\Bundle\SymEditBundle\Entity\Category $children)
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
     * @param array $seo
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
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Post $posts
     * @return Category
     */
    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    
        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Post $posts
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
    
    public function getTotal()
    {
        return $this->posts->count(); 
    }
}
