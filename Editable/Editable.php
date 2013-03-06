<?php

namespace Isometriks\Bundle\SymEditBundle\Editable;

class Editable
{
    private $subject;
    private $type;
    private $parameters;

    public function __construct($subject, $type, $parameters = array())
    {
        $this->setSubject($subject);
        $this->setType($type);
        $this->setParameters($parameters);
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function hasParameter($key)
    {
        return isset($this->parameters[$key]);
    }

    public function getParameter($key)
    {
        if (!$this->hasParameter($key)) {
            throw new \InvalidArgumentException(sprintf('Invalid Editable parameter: "%s"', $key));
        }

        return $this->parameters[$key];
    }

    public function setParameters(array $parameters = array())
    {
        $this->parameters = $parameters;
    }
}