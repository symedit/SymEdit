<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Isometriks\Bundle\UserBundle\Entity\User as BaseUser;
use Isometriks\Bundle\SymEditBundle\Util\Util; 
use Isometriks\Bundle\SymEditBundle\Model\UserInterface; 

/**
 * Isometriks\Bundle\SymEditBundle\Entity\User
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @var integer $id
     */
    protected $id;    
    
    /**
     * @var Isometriks\Bundle\SymEditBundle\Entity\Image
     */
    protected $image;
    
    /**
     * @var ArrayCollection $posts
     */
    protected $posts; 
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }    
    
    public function setUpdated()
    {
        if($image = $this->getImage()){
            if($image->hasFile()){
                $image->setName(Util::slugify($this->getFullname())); 
            }
        }
    }
    
    public function getImage()
    {
        return $this->image; 
    }    
    
    public function setImage(Image $image)
    {
        $this->image = $image;
        $this->setUpdated(); 
        
        return $this; 
    }
    
    public function getPosts()
    {
        return $this->posts; 
    }
}