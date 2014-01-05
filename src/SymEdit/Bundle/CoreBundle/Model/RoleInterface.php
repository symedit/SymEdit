<?php

namespace SymEdit\Bundle\CoreBundle\Model;

interface RoleInterface
{
    public function getId();

    public function setRole($role);
    public function getRole();

    public function setDescription($description);
    public function getDescription();
}
