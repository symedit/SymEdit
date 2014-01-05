<?php

namespace SymEdit\Bundle\CoreBundle\Model;

class Role implements RoleInterface
{
   /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $role
     */
    protected $role;

    /**
     * @var string $description
     */
    protected $description;

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
     * @param  string $role
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
     * @param  string $description
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
