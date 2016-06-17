<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

interface BreadcrumbsInterface extends \IteratorAggregate, \Countable
{
    /**
     * Adds a breadcrumb to the top of the stack.
     *
     * @param string $path
     * @param array  $params
     */
    public function push($title, $path, $params = []);

    /**
     * Adds a breadcrumb to the bottom of the stack.
     *
     * @param string $path
     * @param array  $params
     */
    public function unshift($title, $path, $params = []);

    /**
     * Returns the breadcrumb on the top of the stack.
     *
     * @return array An array with keys path, and params
     */
    public function pop();

    /**
     * Returns all the breadcrumbs in an array.
     *
     * @return array All breadcrumbs
     */
    public function all();
}
