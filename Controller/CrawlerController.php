<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Iterator\RecursivePageIterator;

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

        $root = $this->get('isometriks_symedit.repository.page')->findRoot();
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
