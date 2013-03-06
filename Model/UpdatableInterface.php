<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

interface UpdatableInterface 
{
    public function setUpdatedAt($time); 
    public function getUpdatedAt(); 
}