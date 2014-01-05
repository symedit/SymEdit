<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface BreadcrumbsInterface extends \IteratorAggregate, \Countable
{
    /**
     * Adds a breadcrumb to the top of the stack
     *
     * @param string $path
     * @param array  $params
     */
    public function push($title, $path, $params = array());

    /**
     * Adds a breadcrumb to the bottom of the stack
     *
     * @param string $path
     * @param array  $params
     */
    public function unshift($title, $path, $params = array());

    /**
     * Returns the breadcrumb on the top of the stack
     *
     * @return array An array with keys path, and params
     */
    public function pop();

    /**
     * Returns all the breadcrumbs in an array
     *
     * @return array All breadcrumbs
     */
    public function all();
}
