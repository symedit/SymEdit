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
        $objects = $this->getObjects($parameters);

        foreach ($objects as $object) {
            if (!$this->passCallbacks($object, $parameters['callbacks'])) {
                continue;
            }

            $routes[] = $this->makeEntry($object, $parameters);
        }

        return $routes;
    }

    /**
     * Returns all the objects from the repository
     *
     * @param string $className
     * @param array $parameters
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function getObjects(array $parameters)
    {
        if (!$this->container->has($parameters['repository'])) {
            throw new \InvalidArgumentException(sprintf('Could not generate sitemap, service "%s" not found.', $parameters['repository']));
        }

        $repository = $this->container->get($parameters['repository']);

        return call_user_func(array($repository, $parameters['method']));
    }

    protected function passCallbacks($object, array $callbacks)
    {
        if (count($callbacks) === 0) {
            return true;
        }

        foreach ($callbacks as $callback) {
            if (!call_user_func(array($object, $callback))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Builds a single entry from object and parameters
     *
     * @param mixed $object
     * @param array $parameters
     * @return array
     */
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

    /**
     * Resolves route parameters. If you have $slug for instance it will try
     * to resolve it by checking Object::$slug Object->getSlug() etc.
     *
     * @param mixed $object
     * @param array $routeParams
     * @return array
     */
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

    protected function getPropertyAccessor()
    {
        if ($this->propertyAccessor === null) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }
}