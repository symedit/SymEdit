<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle\Sitemap;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\RouterInterface;

class SitemapFetcher extends ContainerAware
{
    protected $propertyAccessor;

    public function fetchEntries($className, array $parameters)
    {
        $routes = array();
        $objects = $this->getObjects($className, $parameters);

        foreach ($objects as $object) {
            $routes[] = $this->makeEntry($object, $parameters);
        }

        return $routes;
    }

    protected function getObjects($className, array $parameters)
    {
        $repository = $this->container->get($parameters['repository']);

        return call_user_func(array($repository, $parameters['method']));
    }

    protected function makeEntry($object, array $parameters)
    {
        $routeName = $parameters['route']['path'];
        $routeParams = $this->resolveRouteParams($object, $parameters['route']['params']);

        $entry = array(
            'url' => $this->getRouter()->generate($routeName, $routeParams, true),
            'changefreq' => $parameters['changefreq'],
            'priority' => $parameters['priority'],
        );

        if ($parameters['lastmod']) {
            $entry['lastmod'] = $this->getPropertyAccessor()->getValue($object, $parameters['lastmod']);
        }

        return $entry;
    }

    protected function resolveRouteParams($object, $routeParams)
    {
        $resolvedParams = array();

        foreach ($routeParams as $key => $value) {
            if ($value[0] === '$') {
                $value = $this->getPropertyAccessor()->getValue($object, substr($value, 1));
            }

            $resolvedParams[$key] = $value;
        }

        return $resolvedParams;
    }

    /**
     * @return RouterInterface
     */
    protected function getRouter()
    {
        return $this->container->get('router');
    }

    protected function getRoute($routeName)
    {
        return $this->getRouter()->getRouteCollection()->get($routeName);
    }

    protected function getPropertyAccessor()
    {
        if ($this->propertyAccessor === null) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }
}