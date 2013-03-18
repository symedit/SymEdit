<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Isometriks\Bundle\UserBundle\Entity\User as BaseUser;
use Isometriks\Bundle\SymEditBundle\Util\Util; 
use Isometriks\Bundle\SymEditBundle\Model\UserInterface; 
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Image", cascade={"persist"})
     */
    protected $image;
    
    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
     * @ORM\OrderBy({"createdAt"="DESC"})
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