<?php

namespace Isometriks\Bundle\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class User extends BaseUser
{
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $lastName; 
    
    /**
     * @ORM\Column(length=255, nullable=true)
     */
    protected $gplus; 
    
    /**
     * @ORM\Column(type="text", name="biography", nullable=true)
     */
    protected $biography; 

    public function __construct()
    {
        parent::__construct();
    }
    
    public function __toString()
    {
        return $this->getFullname(); 
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

    public function getFullname()
    {
        return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
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
    
    public function getBiography()
    {
        return $this->biography; 
    }
    
    public function setBiography($biography)
    {
        $this->biography = $biography; 
        
        return $this; 
    }
}