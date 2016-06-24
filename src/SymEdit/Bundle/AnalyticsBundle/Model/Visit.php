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

class Visit implements VisitInterface
{
    private $id;
    private $model;
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

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;

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
