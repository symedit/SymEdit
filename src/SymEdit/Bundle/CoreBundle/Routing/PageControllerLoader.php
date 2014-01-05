<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
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