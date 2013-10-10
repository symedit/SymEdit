<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CrawlerController extends Controller
{
    /**
     * @Route("/robots.{_format}", defaults={"_format"="txt"}, name="robots")
     */
    public function robotsAction()
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

    /**
     * @Route("sitemap.{_format}", requirements={"_format"="xml"})
     */
    public function sitemapAction(Request $request)
    {
        $sitemap = $this->get('isometriks.sitemap');
        $urls = $sitemap->getUrls();

        $root = $this->get('isometriks_symedit.page_manager')->findRoot();
        $iterator = new \RecursiveIteratorIterator($root, \RecursiveIteratorIterator::SELF_FIRST);
        
        foreach ($iterator as $page) {
            $urls[] = $this->generateUrl($page->getRoute(), array(), true);
        }

        $response = $this->createResponse();
        $response->setMaxAge(300);

        return $this->render('@IsometriksSitemap/Sitemap/index.xml.twig', array(
            'urls' => $urls,
        ), $response);
    }
}
