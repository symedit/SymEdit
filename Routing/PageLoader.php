<?php

namespace Isometriks\Bundle\SymEditBundle\Routing;

use Symfony\Component\Config\Loader\Loader as BaseLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;

class PageLoader extends BaseLoader
{
    private $pageManager;

    public function __construct(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    /**
     * @param type $resource
     * @param type $type
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function load($resource = null, $type = null)
    {
        $pages = $this->pageManager->findPagesBy(array(
            'pageController' => false,
            'root' => false,
            'display' => true,
        ));

        $collection = new RouteCollection();

        /**
         * Add actual CMS Pages
         */
        foreach ($pages as $page) {
            $defaults = array(
                '_page_id' => $page->getId(),
                '_controller' => 'IsometriksSymEditBundle:Page:show',
            );

            $collection->add($page->getRoute(), new Route($page->getPath(), $defaults));
        }

        return $collection;
    }

    public function supports($resource = null, $type = null)
    {
        return $type === 'symedit_pages';
    }
}