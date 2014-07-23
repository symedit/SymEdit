<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Model;

class SeoPreference
{
    protected $model;
    protected $title;
    protected $description;

    public function __construct($model, array $title, array $description)
    {
        $this->model = $model;
        $this->title = $title;
        $this->description = $description;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(array $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
