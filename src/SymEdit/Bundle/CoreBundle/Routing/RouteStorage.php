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

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Routing\Route;

class RouteStorage
{
    protected $cacheFile;
    protected $routes;

    public function __construct($cacheDir)
    {
        $this->cacheFile = $cacheDir.'/routes.php';
    }

    public function save($routes)
    {
        $this->routes = $routes;

        $serialized = array_map('serialize', $routes);

        $cache = $this->getCache();
        $cache->write(sprintf('<?php return %s;', var_export($serialized, true)));
    }

    protected function getCache()
    {
        return new ConfigCache($this->cacheFile, true);
    }

    protected function loadRoutes()
    {
        $serializedRoutes = require $this->getCache()->getPath();
        $this->routes = array_map('unserialize', $serializedRoutes);
    }

    public function getRoutes()
    {
        if ($this->routes === null) {
            $this->loadRoutes();
        }

        return $this->routes;
    }

    /**
     * @return Route
     */
    public function getRoute($name)
    {
        $routes = $this->getRoutes();

        return $routes[$name];
    }
}
