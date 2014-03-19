<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Model;

class Visit
{
    private $id;
    private $class;
    private $identifier;
    private $visitDate;

    public function __construct()
    {
        $this->visitDate = new \DateTime();
    }

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

    public function getVisitDate()
    {
        return $this->visitDate;
    }

    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }
}