<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteProvider implements RouteProviderInterface
{
    protected $managerRegistry;
    protected $routeConfig;
    protected $accessor;

    public function __construct(ManagerRegistry $managerRegistry, array $routeConfig)
    {
        $this->managerRegistry = $managerRegistry;
        $this->routeConfig = $routeConfig;
    }

    public function getRouteByName($name)
    {
        die('get route by name');
    }

    public function getRouteCollectionForRequest(Request $request)
    {
        $path = $request->getPathInfo();
        $accessor = $this->getPropertyAccessor();
        $collection = new RouteCollection();

        foreach ($this->routeConfig as $className => $config) {
            $repository = $this->getRepository($className);
            $field = $config['field'];

            foreach ($repository->findAll() as $content) {
                $value = $accessor->getValue($content, $field);
                $route = new Route($config['prefix'] . '/' . $value, array_merge(array(
                    '_symedit_entity' => $content,
                ), $config['defaults']));

                $collection->add($config['prefix'] . '/' . $value, $route);
            }
        }

        return $collection;
    }

    /**
     * @return PropertyAccessor $accessor
     */
    protected function getPropertyAccessor()
    {
        if ($this->accessor === null) {
            $this->accessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->accessor;
    }

    protected function getRepository($className)
    {
        return $this->managerRegistry->getRepository($className);
    }

    public function getRoutesByNames($names)
    {
        die('get route by name');
    }
}
