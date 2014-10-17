<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Routing\Route;

class RouteStorage
{
    protected $cacheDir;
    protected $routes;

    public function __construct($cacheDir)
    {
        $this->cacheFile = $cacheDir . '/symedit_routing/routes.php';
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
        $serializedRoutes = require $this->getCache();
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