<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

abstract class PageManager implements PageManagerInterface
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function createPage()
    {
        $class = $this->getClass();
        $page = new $class();

        return $page;
    }

    public function findPageByPath($path)
    {
        return $this->findPageBy(array(
            'path' => $path,
        ));
    }

    public function getClass()
    {
        return $this->class;
    }
}