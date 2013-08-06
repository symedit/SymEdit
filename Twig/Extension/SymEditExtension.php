<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Isometriks\Bundle\SymEditBundle\Model\Page;

class SymEditExtension extends \Twig_Extension implements ContainerAwareInterface
{
    private $extensions;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container, array $extensions = array())
    {
        $this->setContainer($container);
        $this->extensions = $extensions;
    }

    public function getGlobals()
    {
        $em = $this->container->get('doctrine')->getManager();
        $pages = $em->getRepository('IsometriksSymEditBundle:Page');

        $globals = array(
            'Root' => $pages->findRoot(),
            'Tree' => $pages,
        );

        $context = $this->container->get('security.context');

        if($context->getToken() !== null && $context->isGranted('ROLE_ADMIN')){
            $globals['extensions'] = $this->getExtensions();
            $globals['stylizer'] = $this->container->has('isometriks_stylizer.stylizer');
        }

        /**
         *  Inject the Page variable globally in case
         *  you skipped it in the controller, or didn't need it
         *  as well as the breadcrumbs
         */
        if($this->container->has('request')){
            $request = $this->container->get('request');

            if($request->attributes->has('_page')){
                $page = $request->attributes->get('_page');
                $page->setActive(true, true);
                $seo = $page->getSeo();
            } else {
                $page = new Page();
                $page->setPath($request->getPathInfo());
                $seo = array();
            }

            $globals['Page'] = $page;
            $globals['SEO'] = $seo;
            $globals['Breadcrumbs'] = $this->container->get('isometriks_symedit.breadcrumbs');
        }


        return $globals;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('plain', array($this, 'plain')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('route_exists', array($this, 'routeExists')),
        );
    }

    private function getExtensions()
    {
        $extensions = array();
        foreach($this->extensions as $extension){
            if($this->container->get('security.context')->isGranted($extension['role'])){
                $extensions[] = $extension;
            }
        }

        return $extensions;
    }

    /**
     * This is used for things like generating meta descriptions from page content. We need
     * it to be plain text with no breaks. There is a limit which will truncate the text so
     * meta tags won't be filled with too much text.
     *
     * @param string $text
     * @param int $limit
     * @return string
     */
    public function plain($text, $limit = null, $ellipsis = null)
    {
        $text = strip_tags($text);
        $text = htmlentities($text);
        $text = str_replace(array("\n", "\r"), ' ', $text);
        $len  = strlen($text);

        if (isset($limit) && is_int($limit) && $len > $limit) {
            $text = substr($text, 0, $limit);

            if($ellipsis !== null){
                $text .= $ellipsis;
            }
        }

        return $text;
    }

    /**
     * Check for existence of a route
     *
     * @param string $name Route Name
     * @return boolean
     */
    public function routeExists($name)
    {
        $router = $this->container->get('router');

        return array_key_exists($name, $router->getRouteCollection()->all());
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'SymEditBundleExtension';
    }
}