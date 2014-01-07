<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use SymEdit\Bundle\CoreBundle\Iterator\RecursivePageIterator;

class CrawlerController extends Controller
{
    function robotsAction()
    {
        $settings = $this->get('isometriks_settings.settings');

        if ($settings->has('webmaster.robots')) {
            $allow = $settings->get('webmaster.robots') === 'allow';
        } else {
            $env = $this->container->getParameter('kernel.environment');
            $allow = $env === 'prod';
        }

        return $this->render('@SymEdit/Crawler/robots.txt.twig', array(
            'Allow' => $allow,
        ));
    }

    public function sitemapAction(Request $request)
    {
        $sitemap = $this->get('isometriks.sitemap');
        $urls = $sitemap->getUrls();

        $root = $this->get('symedit.repository.page')->findRoot();
        $pageIterator = new RecursivePageIterator($root);
        $recursiveIterator = new \RecursiveIteratorIterator($pageIterator, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($recursiveIterator as $page) {
            $urls[] = $this->generateUrl($page->getRoute(), array(), true);
        }

        $response = $this->createResponse();
        $response->setMaxAge(300);

        return $this->render('@IsometriksSitemap/Sitemap/index.xml.twig', array(
            'urls' => $urls,
        ), $response);
    }
}
