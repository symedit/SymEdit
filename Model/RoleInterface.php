<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

interface RoleInterface
{
    public function getId(); 
    
    public function setRole($role); 
    public function getRole(); 
    
    public function setDescription($description); 
    public function getDescription(); 
}