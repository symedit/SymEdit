<?php

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
