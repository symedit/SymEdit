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

use Symfony\Bundle\FrameworkBundle\Routing\DelegatingLoader;

class RouteLoader extends DelegatingLoader
{
    protected $routeManager;
    protected $storage;

    public function setRouteManager(RouteManager $routeManager)
    {
        $this->routeManager = $routeManager;
    }

    public function setRouteStorage(RouteStorage $storage)
    {
        $this->storage = $storage;
    }

    public function load($resource, $type = null)
    {
        $collection = parent::load($resource, $type);
        $stored = array();

        // Remove any page controller routes
        foreach ($this->routeManager->getAllRoutes() as $routeName) {
            $stored[$routeName] = $collection->get($routeName);
            $collection->remove($routeName);
        }

        $this->storage->save($stored);

        return $collection;
    }
}
