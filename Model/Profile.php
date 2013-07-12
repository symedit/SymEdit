<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

class Profile implements ProfileInterface
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $user;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullname()
    {
        return rtrim(sprintf('%s %s', $this->getFirstName(), $this->getLastName()));
    }   
    
    public function getUser()
    {
        return $this->user;
    }
}