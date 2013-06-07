<?php

namespace Isometriks\Bundle\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Isometriks\Bundle\SymEditBundle\Entity\Image; 
use Isometriks\Bundle\SymEditBundle\Entity\Post; 
use Isometriks\Bundle\SymEditBundle\Model\UserInterface; 
use Isometriks\Bundle\SymEditBundle\Util\Util; 


class User extends BaseUser implements UserInterface
{
    /**
     * @var integer $id
     */
    protected $id;    
    
    /**
     * @var \Isometriks\Bundle\SymEditBundle\Entity\Image
     */
    protected $image;
    
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $posts
     */
    protected $posts; 
    
    /**
     * @var string $firstName
     */
    protected $firstName;

    /**
     * @var string $lastName
     */
    protected $lastName; 
    
    /**
     * @var string $gplus
     */
    protected $gplus; 
    
    /**
     * @var string $biography
     */
    protected $biography; 
    
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
    
    /**
     * Actions to perform when the entity has been updated. 
     */
    public function setUpdated()
    {
        if($image = $this->getImage()){
            if($image->hasFile()){
                $image->setName(Util::slugify($this->getFullname())); 
            }
        }
    }
    
    /**
     * Gets user's image
     * 
     * @return \Isometriks\Bundle\SymEditBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image; 
    }    
    
    /**
     * Set the user's image
     * 
     * @param \Isometriks\Bundle\UserBundle\Entity\Image $image
     * @return \Isometriks\Bundle\UserBundle\Entity\User
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
        $this->setUpdated(); 
        
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Gets the user's full name
     * 
     * @return string $fullname
     */
    public function getFullname()
    {
        return rtrim(sprintf('%s %s', $this->getFirstName(), $this->getLastName()));
    }

    /**
     * Set gplus
     *
     * @param string $gplus
     * @return User
     */
    public function setGplus($gplus)
    {
        $this->gplus = $gplus;
    
        return $this;
    }

    /**
     * Get gplus
     *
     * @return string 
     */
    public function getGplus()
    {
        return $this->gplus;
    }
    
    /**
     * Get the user's biography
     * 
     * @return string $biography
     */
    public function getBiography()
    {
        return $this->biography; 
    }
    
    /**
     * Set user biography
     * 
     * @param string $biography
     * @return \Isometriks\Bundle\UserBundle\Entity\User
     */
    public function setBiography($biography)
    {
        $this->biography = $biography; 
        
        return $this; 
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
