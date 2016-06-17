<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Routing;

class PageController implements \Serializable
{
    protected $name;
    protected $routes;

    public function __construct($name, array $routes)
    {
        $this->name = $name;
        $this->routes = $routes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function hasRoute($routeName)
    {
        return in_array($routeName, $this->getRoutes());
    }

    public function serialize()
    {
        return serialize([
            'name' => $this->name,
            'routes' => $this->routes,
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->name = $data['name'];
        $this->routes = $data['routes'];
    }
}
