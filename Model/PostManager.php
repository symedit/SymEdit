<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

abstract class PostManager implements PostManagerInterface
{
    const STATUS_FILTER = 'post_published';

    protected $class;
    protected $statusFilter;

    public function __construct($class)
    {
        $this->class = $class;
        $this->statusFilter = true;
    }

    public function createPost()
    {
        $class = $this->getClass();
        $post = new $class();

        return $post;
    }

    public function findPostBySlug($slug)
    {
        return $this->findPostBy(array(
            'slug' => $slug,
        ));
    }

    public function enableStatusFilter()
    {
        $this->statusFilter = true;
    }

    public function disableStatusFilter()
    {
        $this->statusFilter = false;
    }

    public function getClass()
    {
        return $this->class;
    }
}