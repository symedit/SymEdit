<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

use Isometriks\Bundle\SymEditBundle\Entity\Image; 

interface UserInterface
{
    public function getId(); 

    public function getFirstName(); 
    public function setFirstName($firstName); 
    
    public function getLastName();
    public function setLastName($lastName); 

    public function getFullname();
    
    public function getBiography(); 
    public function setBiography($biography); 
    
    /**
     * Get social media associative array
     * 
     * @return array Associative array of social media URLs
     */
    public function getSocial(); 
    
    /**
     * Sets Social Media
     * 
     * @param array $social
     */
    public function setSocial(array $social); 
    
    public function getImage(); 
    public function setImage(Image $image); 
    
    public function setUpdated(); 
}