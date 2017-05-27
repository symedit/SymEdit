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

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class SitemapFetcher
{
    use ContainerAwareTrait;

    protected $propertyAccessor;

    public function fetchEntries($className, array $parameters)
    {
        /*
         *  Check if route exists, if route starts with a $ it is dynamic
         *  so don't fail here.
         */
        $routeName = $parameters['route']['path'];

        if (!$this->hasRoute($routeName) && $routeName[0] !== '$') {
            // Ignore routes that are not found?
            if ($parameters['route']['ignore']) {
                return [];
            }

            throw new \Exception(sprintf('Not ignoring unfound routes - Could not find "%s"', $routeName));
        }

        $routes = [];
        $objects = $this->getObjects($parameters);

        foreach ($objects as $object) {
            if (!$this->passCallbacks($object, $parameters['callbacks'])) {
                continue;
            }

            $entry = $this->makeEntry($object, $parameters);

            if ($entry !== null) {
                $routes[] = $entry;
            }
        }

        return $routes;
    }

    /**
     * Returns all the objects from the repository.
     *
     * @param string $className
     * @param array  $parameters
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getObjects(array $parameters)
    {
        if (!$this->container->has($parameters['repository'])) {
            throw new \InvalidArgumentException(sprintf('Could not generate sitemap, service "%s" not found.', $parameters['repository']));
        }

        $repository = $this->container->get($parameters['repository']);

        return call_user_func([$repository, $parameters['method']]);
    }

    protected function passCallbacks($object, array $callbacks)
    {
        if (count($callbacks) === 0) {
            return true;
        }

        foreach ($callbacks as $callback) {
            if (!call_user_func([$object, $callback])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Builds a single entry from object and parameters.
     *
     * @param mixed $object
     * @param array $parameters
     *
     * @return array
     */
    protected function makeEntry($object, array $parameters)
    {
        $routeName = $this->resolveParam($object, $parameters['route']['path']);
        $routeParams = $this->resolveRouteParams($object, $parameters['route']['params']);

        $entry = [
            'url' => $this->getRouter()->generate($routeName, $routeParams, true),
            'changefreq' => $parameters['changefreq'],
            'priority' => $parameters['priority'],
        ];

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
     *
     * @return array
     */
    protected function resolveRouteParams($object, $routeParams)
    {
        $resolvedParams = [];

        foreach ($routeParams as $key => $value) {
            $resolvedParams[$key] = $this->resolveParam($object, $value);
        }

        return $resolvedParams;
    }

    /**
     * Resolves a single string.
     *
     * @param mixed  $object
     * @param string $string
     *
     * @return string
     */
    protected function resolveParam($object, $string)
    {
        if ($string[0] === '$') {
            $string = $this->getPropertyAccessor()->getValue($object, substr($string, 1));
        }

        return $string;
    }

    protected function hasRoute($routeName)
    {
        try {
            $this->getRouter()->generate($routeName);

            return true;
        } catch (MissingMandatoryParametersException $e) {
            return true;
        } catch (RouteNotFoundException $e) {
            return false;
        }
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
