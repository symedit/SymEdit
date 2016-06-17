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

class Breadcrumbs implements BreadcrumbsInterface
{
    protected $crumbs = [];

    public function all()
    {
        return $this->crumbs;
    }

    public function unshift($title, $path, $params = [])
    {
        array_unshift($this->crumbs, [
            'title' => $title,
            'path' => $path,
            'params' => $params,
        ]);
    }

    public function pop()
    {
        return array_pop($this->crumbs);
    }

    public function push($title, $path, $params = [])
    {
        $this->crumbs[] = [
            'title' => $title,
            'path' => $path,
            'params' => $params,
        ];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->crumbs);
    }

    public function count()
    {
        return count($this->crumbs);
    }
}
