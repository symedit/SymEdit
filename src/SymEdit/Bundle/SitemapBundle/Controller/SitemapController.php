<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle\Controller;

use SymEdit\Bundle\SitemapBundle\Event\SitemapEvent;
use SymEdit\Bundle\SitemapBundle\Event\SitemapEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SitemapController extends Controller
{
    public function indexAction()
    {
        $manager = $this->container->get('symedit_sitemap.manager');
        $sitemap = $manager->getSitemap();

        // Dispatch event to add extra entries
        $event = new SitemapEvent($sitemap);
        $this->container->get('event_dispatcher')->dispatch(SitemapEvents::SITEMAP_VIEW, $event);

        return $this->render('SymEditSitemapBundle:Sitemap:index.xml.twig', [
            'sitemap' => $sitemap,
        ]);
    }
}
