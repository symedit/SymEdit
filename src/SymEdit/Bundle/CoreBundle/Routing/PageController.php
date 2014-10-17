<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

class PageController
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
}
