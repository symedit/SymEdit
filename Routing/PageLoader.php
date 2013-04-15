<?php

namespace Isometriks\Bundle\SymEditBundle\Routing;

use Symfony\Component\Config\Loader\Loader as BaseLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Doctrine\ORM\EntityManager;

class PageLoader extends BaseLoader
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * TODO: We should let PageController pages have a route anyway, even if they
     * point to the same place. This way we can use path(page.route) to get any
     * of the routes!
     * 
     * @param type $resource
     * @param type $type
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function load($resource = null, $type = null)
    {
        $repo       = $this->em->getRepository($resource);
        $pages      = $repo->findCMSPages(true);
        $collection = new RouteCollection();

        /**
         * Add actual CMS Pages
         */
        foreach ($pages as $page) {

            $defaults = array(
                'id' => $page->getId(),
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