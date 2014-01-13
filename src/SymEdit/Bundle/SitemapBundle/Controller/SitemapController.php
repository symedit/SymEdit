<?php

namespace SymEdit\Bundle\SitemapBundle\Controller;

use SymEdit\Bundle\SitemapBundle\Event\SitemapEvent;
use SymEdit\Bundle\SitemapBundle\Event\SitemapEvents;
use Symfony\Component\DependencyInjection\ContainerAware;

class SitemapController extends ContainerAware
{
    public function indexAction()
    {
        $manager = $this->container->get('symedit_sitemap.manager');
        $sitemap = $manager->getSitemap();

        // Dispatch event to add extra entries
        $event = new SitemapEvent($sitemap);
        $this->container->get('event_dispatcher')->dispatch(SitemapEvents::SITEMAP_VIEW, $event);

        return $this->container->get('templating')->renderResponse('SymEditSitemapBundle:Sitemap:index.xml.twig', array(
            'sitemap' => $sitemap,
        ));
    }
}
