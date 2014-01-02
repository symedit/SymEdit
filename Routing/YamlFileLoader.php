<?php

namespace Isometriks\Bundle\SymEditBundle\Routing;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Routing\Loader\YamlFileLoader as BaseYamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

class YamlFileLoader extends BaseYamlFileLoader
{
    protected $pageControllerLoader;

    public function __construct(FileLocatorInterface $locator, PageControllerLoader $pageControllerLoader)
    {
        parent::__construct($locator);

        $this->pageControllerLoader = $pageControllerLoader;
    }

    protected function parseImport(RouteCollection $collection, array $config, $path, $file)
    {
        $defaults = isset($config['defaults']) ? $config['defaults'] : array();
        $symedit = isset($defaults['_symedit']) ? $defaults['_symedit'] : array();

        // If page_controller not set, bypass
        if (!isset($symedit['page_controller'])) {
            parent::parseImport($collection, $config, $path, $file);

            return;
        }

        $pageControllerPath = $symedit['page_controller'];
        $defaultRoute = isset($symedit['default_route']) ? $symedit['default_route'] : null;

        /**
         * Get the routes from the parent before we prefix them, if at all
         */
        $importedCollection = new RouteCollection();
        parent::parseImport($importedCollection, $config, $path, $file);

        $finalCollection = $this->pageControllerLoader->prepareCollection($importedCollection, $pageControllerPath, $defaultRoute);

        /**
         * Add resulting collection to the main collection
         */
        $collection->addCollection($finalCollection);
    }
}