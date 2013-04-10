<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

/**
 * Isometriks\Bundle\SymEditBundle\Entity\Role
 */
class Role
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $role
     */
    private $role;

    /**
     * @var string $description
     */
    private $description;


    public function __toString()
    {
        return $this->getRole(); 
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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
