<?php

namespace Isometriks\Bundle\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Isometriks\Bundle\SymEditBundle\Model\ProfileInterface;
use Isometriks\Bundle\SymEditBundle\Entity\Post; 
use Isometriks\Bundle\SymEditBundle\Model\UserInterface; 


class User extends BaseUser implements UserInterface
{
    /**
     * @var integer $id
     */
    protected $id;    
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $posts
     */
    protected $posts; 
    
    protected $profile;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(); 
        
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }    
    
    /**
     * @return string $fullname
     */
    public function __toString()
    {
        return $this->getFullname(); 
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
    
    public function getProfile()
    {
        return $this->profile;
    }
    
    public function setProfile(ProfileInterface $profile)
    {
        $this->profile = $profile;
        
        return $this;
    }
    
    /**
     * Get the user's blog posts
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts; 
    }

    /**
     * Add posts
     *
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Post $posts
     * @return User
     */
    public function addPost(Post $posts)
    {
        $posts->setAuthor($this); 
        $this->posts[] = $posts;
    
        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Post $posts
     */
    public function removePost(Post $posts)
    {
        $this->posts->removeElement($posts);
    }
}
