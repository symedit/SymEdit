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
    
    public function getGplus(); 
    public function setGplus($gplus); 
    
    public function getImage(); 
    public function setImage(Image $image); 
    
    public function setUpdated(); 
}