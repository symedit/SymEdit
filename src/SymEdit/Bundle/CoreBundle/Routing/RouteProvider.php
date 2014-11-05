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

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\DoctrineProvider;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteProvider extends DoctrineProvider implements RouteProviderInterface
{
    protected $routeManager;
    protected $storage;
    protected $routeByNameCache = array();
    protected $repository;

    public function __construct(RouteManager $routeManager, RouteStorage $storage, ManagerRegistry $managerRegistry, $className = null)
    {
        $this->routeManager = $routeManager;
        $this->storage = $storage;

        parent::__construct($managerRegistry, $className);
    }

    public function getRouteByName($name)
    {
        if (!array_key_exists($name, $this->routeByNameCache)) {
            if ($route = $this->doGetRouteByName($name)) {
                $this->routeByNameCache[$name] = $route;
            } else {
                return;
            }
        }

        return $this->routeByNameCache[$name];
    }

    protected function doGetRouteByName($name)
    {
        // Homepage route
        if ($name === 'homepage') {
            $homepage = $this->getRepository()->findOneBy(array(
                'homepage' => true,
            ));

            return $this->createRoute($homepage);
        }

        // Page route
        if (strpos($name, 'page/') !== false) {
            $page = $this->getRepository()->find(substr($name, 5));

            if (!$page) {
                throw new RouteNotFoundException(sprintf('Could not find route for "%s".', $name));
            }

            return $this->createRoute($page);
        }

        // Finally try to get a Page Controller
        return $this->getPageControllerRoute($name);
    }


    protected function getPageControllerRoute($name)
    {
        $pageController = $this->routeManager->findByRoute($name);

        if (!$pageController) {
            throw new RouteNotFoundException('No route found in SymEdit Router');
        }

        $page = $this->getRepository()->findOneBy(array(
            'pageController' => true,
            'pageControllerPath' => $pageController->getName(),
        ));

        // No Page connected so this route is inactive
        if (!$page) {
            throw new RouteNotFoundException(sprintf(
                'Page Controller "%s" does not have an active page so this route is inactive',
                $pageController->getName()
            ));
        }

        $route = $this->storage->getRoute($name);

        // Add Prefix
        $prefix = rtrim($page->getPath(), '/');
        $route->setPath($prefix.'/'.ltrim($route->getPath(), '/'));

        // Add this page
        $route->addDefaults(array(
            '_page' => $page,
        ));

        return $route;
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        $path = $request->getPathInfo();
        $collection = new RouteCollection();

        // Check for direct match
        $page = $this->getRepository()->findOneBy(array(
            'path' => $path,
            'pageController' => false,
        ));

        if ($page) {
            $collection->add($page->getRoute(), $this->createRoute($page));

            return $collection;
        }

        // Check for page controllers
        $paths = $this->getPathArray($path);
        $pages = $this->getRepository()->findBy(array(
            'path' => $paths,
            'pageController' => true,
        ), array(
            'path' => 'DESC',
        ));

        // Get the one with the longest path
        $page = reset($pages);

        // No page found
        if (!$page) {
            return $collection;
        }

        // Page Controller found, attach specified routes
        $pageController = $this->routeManager->get($page->getPageControllerPath());
        $storedRoutes = $this->storage->getRoutes();

        foreach ($pageController->getRoutes() as $routeName) {
            $collection->add($routeName, $storedRoutes[$routeName]);
        }

        // Clone the collection so we aren't altering the stored routes
        $collection = clone $collection;

        // Add the page's prefix
        $collection->addPrefix($page->getPath());
        $collection->addDefaults(array(
            '_page' => $page,
        ));

        return $collection;
    }

    /**
     * Split something like /blog/category/general into
     * [/blog, /blog/category]
     * So we can search for a page with the same path.
     */
    protected function getPathArray($path)
    {
        $path = rtrim($path, '/') . '/';
        $paths = array();
        $lastOffset = 1;

        while (($lastOffset = strpos($path, '/', $lastOffset)) !== false) {
            $paths[] = substr($path, 0, $lastOffset);
            $lastOffset++;
        }

        return $paths;
    }

    public function getRoutesByNames($names)
    {
        $routes = array();

        foreach ($names as $name) {
            try {
                $routes[] = $this->getRouteByName($name);
            } catch (RouteNotFoundException $e) {
                // Could not find
            }
        }

        return $routes;
    }

    protected function createRoute(PageInterface $page)
    {
        $defaults = array(
            '_controller' => 'symedit.controller.page:showAction',
            '_page' => $page,
        );

        // Merge in other defaults for non-page controllers
        if (!$page->getPageController()) {
            $defaults = array_merge($defaults, array(
                '_sylius' => array(
                    'cache' => array(
                        'last_modified' => 'resource.updatedAt',
                        'public' => true,
                    ),
                ),
            ));
        }

        return new Route($page->getPath(), $defaults);
    }

    /**
     * @return RepositoryInterface
     */
    protected function getRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->managerRegistry->getRepository($this->className);
        }

        return $this->repository;
    }
}
