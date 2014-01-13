<?php

namespace SymEdit\Bundle\SitemapBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

class SitemapController extends ContainerAware
{
    public function indexAction()
    {
        $manager = $this->container->get('symedit_sitemap.manager');
        $sitemap = $manager->getSitemap();

        return $this->container->get('templating')->renderResponse('SymEditSitemapBundle:Sitemap:index.xml.twig', array(
            'sitemap' => $sitemap,
        ));
    }
}
