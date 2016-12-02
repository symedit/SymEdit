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
    protected $routeByNameCache = [];
    protected $repository;

    public function __construct(RouteManager $routeManager, RouteStorage $storage, ManagerRegistry $managerRegistry, $className = null)
    {
        $this->routeManager = $routeManager;
        $this->storage = $storage;

        parent::__construct($managerRegistry, $className);
    }

    /**
     * Cache routes so we don't have to do database lookups again.
     *
     * @param string $name
     *
     * @return Route
     *
     * @throws RouteNotFoundException
     */
    public function getRouteByName($name)
    {
        if (!array_key_exists($name, $this->routeByNameCache)) {
            $this->routeByNameCache[$name] = $this->doGetRouteByName($name);
        }

        return $this->routeByNameCache[$name];
    }

    protected function doGetRouteByName($name)
    {
        // Homepage route
        if ($name === 'homepage') {
            $homepage = $this->getRepository()->findOneBy([
                'homepage' => true,
            ]);

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

        $page = $this->getRepository()->findOneBy([
            'pageController' => true,
            'pageControllerPath' => $pageController->getName(),
        ]);

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
        $route->addDefaults([
            '_page' => $page,
        ]);

        return $route;
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        // Check for direct match
        $page = $this->getRepository()->findOneBy([
            'path' => $request->getPathInfo(),
            'pageController' => false,
        ]);

        if ($page) {
            $collection = new RouteCollection();
            $collection->add($page->getRoute(), $this->createRoute($page));

            return $collection;
        }

        // Try to get Page Controller
        return $this->findPageControllerForRequest($request);
    }

    /**
     * Try to get a page controller based on partial match.
     *
     * @param Request $request
     *
     * @return PageInterface
     */
    protected function findPageControllerForRequest(Request $request)
    {
        $path = $request->getPathInfo();

        $paths = $this->getPathArray($path);
        $pages = $this->getRepository()->findBy([
            'path' => $paths,
            'pageController' => true,
        ], [
            'path' => 'DESC',
        ]);

        // Get the one with the longest path
        $page = reset($pages);

        // Could not find, return empty collction
        if (!$page) {
            return new RouteCollection();
        }

        return $this->getPageControllerRoutes($page);
    }

    /**
     * Get a route collection for all routes associated to a page controller.
     *
     * @param PageInterface $page
     *
     * @return RouteCollection
     *
     * @throws RouteNotFoundException
     */
    protected function getPageControllerRoutes(PageInterface $page)
    {
        // Page Controller found, attach specified routes
        $pageController = $this->routeManager->get($page->getPageControllerPath());
        $storedRoutes = $this->storage->getRoutes();
        $collection = new RouteCollection();

        foreach ($pageController->getRoutes() as $routeName) {
            if (!isset($storedRoutes[$routeName])) {
                throw new RouteNotFoundException(
                    sprintf('Could not find route in page controller config: "%s"', $routeName)
                );
            }

            $route = $storedRoutes[$routeName];

            // Mark the index route
            if ($route->getPath() === '/') {
                $route->addDefaults([
                    '_controller_index' => true,
                ]);
            }

            $collection->add($routeName, $route);
        }

        // Clone the collection so we aren't altering the stored routes
        $clonedCollection = clone $collection;

        // Add the page's prefix
        $clonedCollection->addPrefix($page->getPath());
        $clonedCollection->addDefaults([
            '_page' => $page,
        ]);

        return $clonedCollection;
    }

    /**
     * Split something like /blog/category/general into
     * [/blog, /blog/category]
     * So we can search for a page with the same path.
     */
    protected function getPathArray($path)
    {
        // Homepage
        if ($path === '/') {
            return ['/'];
        }

        $path = rtrim($path, '/').'/';
        $paths = ['/'];
        $lastOffset = 1;

        while (($lastOffset = strpos($path, '/', $lastOffset)) !== false) {
            $paths[] = substr($path, 0, $lastOffset);
            ++$lastOffset;
        }

        return $paths;
    }

    public function getRoutesByNames($names)
    {
        if ($names === null) {
            $collection = new RouteCollection();

            $pages = $this->getRepository()->findBy([
                'pageController' => true,
            ]);

            foreach ($pages as $page) {
                $collection->addCollection($this->getPageControllerRoutes($page));
            }

            return $collection;
        }

        $routes = [];

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
        $defaults = [
            '_controller' => 'symedit.controller.page:showAction',
            '_page' => $page,
        ];

        // Merge in other defaults for non-page controllers
        if (!$page->getPageController()) {
            $defaults = array_merge($defaults, [
                'path' => $page->getPath(),
                '_sylius' => [
                    'cache' => [
                        'last_modified' => 'resource.updatedAt',
                        'public' => true,
                    ],
                    'criteria' => [
                        'path' => '$path',
                    ],
                ],
            ]);
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
