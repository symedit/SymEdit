<?php

namespace SymEdit\Bundle\AnalyticsBundle\Model;

class Visit
{
    private $id;
    private $class;
    private $identifier;

    public function getId()
    {
        return $this->id;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }
}