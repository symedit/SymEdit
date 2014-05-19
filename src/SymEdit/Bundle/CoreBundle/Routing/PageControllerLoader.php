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

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Routing\RouteCollection;

class PageControllerLoader
{
    protected $pageRepository;

    public function __construct(RepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function prepareCollection(RouteCollection $collection, $pageControllerPath, $defaultRouteName = null)
    {
        $page = $this->pageRepository->findOneBy(array(
            'pageController' => true,
            'pageControllerPath' => $pageControllerPath,
        ));

        /**
         * Page not found, just return a blank collection
         */
        if ($page === null) {
            return new RouteCollection();
        }

        /**
         * We need to duplicate the index route for the page so you can call it either way
         */
        $defaultRoute = $this->findDefaultRoute($collection, $defaultRouteName);
        $defaultRoute->addDefaults(array(
            '_default_route' => true,
        ));
        $collection->add($page->getRoute(), clone $defaultRoute);

        /**
         * Now we need to add the prefix of the page, and add the _page_id for the listener
         */
        $collection->addPrefix($page->getPath());
        $collection->addDefaults(array(
            '_page_id' => $page->getId(),
        ));

        return $collection;
    }

    /**
     * Attempt to find default route for the controller, if none is provided
     * then find a route with path "/" and assume it is the default.
     *
     * @param  \Symfony\Component\Routing\RouteCollection $collection
     * @param  string                                     $defaultRouteName
     * @return \Symfony\Component\Routing\Route
     * @throws \Exception
     */
    public function findDefaultRoute(RouteCollection $collection, $defaultRouteName = null)
    {
        $defaultRoute = $defaultRouteName === null ? null : $collection->get($defaultRouteName);

        if ($defaultRoute !== null) {
            return $defaultRoute;
        }

        /**
         * Route not found or not provided, lets search for '/'
         */
        foreach ($collection as $route) {
            if ($route->getPath() === '/') {
                return $route;
            }
        }

        throw new \Exception('Could not find a default route.');
    }
}
