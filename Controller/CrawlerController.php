<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CrawlerController extends Controller
{
    /**
     * @Route("/robots.{_format}", defaults={"_format"="txt"}, name="robots")
     * @Template()
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

        return array(
            'Allow' => $allow,
        );
    }

    /**
     * @Route("sitemap.{_format}", defaults={"_format"="xml"})
     * @Template("IsometriksSitemapBundle:Sitemap:index.xml.twig")
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

        return array(
            'urls' => $urls,
        );
    }
}
