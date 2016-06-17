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

use InvalidArgumentException;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;

class RouteManager
{
    protected $routeLoader;
    protected $loader;
    protected $resources;
    protected $pageControllers;
    protected $cacheFile;
    protected $debug;

    public function __construct(LoaderInterface $loader, array $resources, $cacheDir, $debug)
    {
        $this->loader = $loader;
        $this->resources = $resources;
        $this->cacheFile = $cacheDir.'/page_controllers.php';
        $this->debug = $debug;
    }

    public function getPageControllers()
    {
        if ($this->pageControllers === null) {
            $cache = new ConfigCache($this->cacheFile, $this->debug);

            if ($cache->isFresh()) {
                $this->pageControllers = unserialize(require $cache->getPath());
            } else {
                $this->loadPageControllers();
                $cache->write(sprintf('<?php return %s;', var_export(serialize($this->pageControllers), true)));
            }
        }

        return $this->pageControllers;
    }

    protected function loadPageControllers()
    {
        $configuration = new RoutingConfiguration();
        $processor = new Processor();

        $configs = [];
        $resources = [];
        foreach ($this->resources as $resource) {
            $configs[] = $this->loader->load($resource);
            $resources[] = new FileResource($resource);
        }

        $config = $processor->processConfiguration($configuration, $configs);

        foreach ($config as $name => $processed) {
            $pageController = new PageController($name, $processed['routes']);
            $this->add($pageController);
        }
    }

    public function add(PageController $pageController)
    {
        $this->pageControllers[$pageController->getName()] = $pageController;
    }

    public function get($name)
    {
        if (!array_key_exists($name, $this->getPageControllers())) {
            throw new InvalidArgumentException(sprintf('Page controller "%s" does not exist.', $name));
        }

        return $this->pageControllers[$name];
    }

    public function findByRoute($routeName)
    {
        foreach ($this->getPageControllers() as $pageController) {
            if ($pageController->hasRoute($routeName)) {
                return $pageController;
            }
        }

        return false;
    }

    public function getAllRoutes()
    {
        $routes = [];

        foreach ($this->getPageControllers() as $pageController) {
            $routes = array_merge($routes, $pageController->getRoutes());
        }

        return $routes;
    }
}
