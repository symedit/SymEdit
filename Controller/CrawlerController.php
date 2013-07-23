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
     * @Route("sitemap.{_format}", defaults={"_format"="xml"})
     */
    public function sitemapAction(Request $request)
    {
        $sitemap = $this->get('isometriks.sitemap');
        $urls = $sitemap->getUrls();

        // Add the Page urls to it
        // TODO: This should be recursive so anything under a non-display shouldn't display either
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('IsometriksSymEditBundle:Page')->findBy(array(
            'display' => true,
            'root' => false,
            'pageController' => false,
        ));

        foreach ($pages as $page) {
            $urls[] = sprintf('http://%s%s', $request->getHttpHost(), $page->getPath());
        }

        $response = $this->createResponse();
        $response->setMaxAge(60);

        return $this->render('@IsometriksSitemap/Sitemap/index.xml.twig', array(
            'urls' => $urls,
        ), $response);
    }
}
