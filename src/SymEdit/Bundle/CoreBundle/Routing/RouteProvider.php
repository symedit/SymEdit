<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RouteProvider implements RouteProviderInterface
{
    protected $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function getRouteByName($name)
    {
        die('get route by name');
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        $path = $request->getPathInfo();
        $repo = $this->managerRegistry->getRepository('SymEdit\Bundle\CoreBundle\Model\Page');
        $pages = $repo->findAll();

        $collection = new \Symfony\Component\Routing\RouteCollection();

        foreach ($pages as $page) {
            $route = new \Symfony\Component\Routing\Route('/cms/pages/' . $page->getId());
            $route->addDefaults(array(
                '_page' => $page,
                '_controller' => 'symedit.controller.page:showAction',
            ));

            $collection->add('/cms/pages/' . $page->getId(), $route);
        }

        return $collection;
    }

    public function getRoutesByNames($names)
    {
        die('get route by name');
    }
}
