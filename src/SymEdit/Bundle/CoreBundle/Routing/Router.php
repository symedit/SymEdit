<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\Routing\RouteCollection;

class Router extends BaseRouter
{
    protected $routeManager;
    protected $storage;
    protected $stored = false;

    public function setRouteManager(RouteManager $routeManager)
    {
        $this->routeManager = $routeManager;
    }

    public function setRouteStorage(RouteStorage $storage)
    {
        $this->storage = $storage;
    }

    public function getRouteCollection()
    {
        $collection = parent::getRouteCollection();

        // Remove any page controller routes
        if (!$this->stored) {
            $this->storeRoutes($collection);
        }

        return $collection;
    }

    protected function storeRoutes(RouteCollection $collection)
    {
        $stored = array();

        foreach ($this->routeManager->getAllRoutes() as $routeName) {
            $stored[$routeName] = $collection->get($routeName);
            $collection->remove($routeName);
        }

        $this->storage->save($stored);
        $this->stored = true;
    }
}
