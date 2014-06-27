<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * @TODO: Uhh don't inject the container. There's only like 2 services in here now, this is gross.
 */
class SymEditExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        $globals = array();

        if ($this->container->has('request')) {
            $request = $this->container->get('request');
            $page = $request->attributes->get('_page');

            $globals['Page'] = $page;
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
            new \Twig_SimpleFunction('symedit_breadcrumbs_get', array($this, 'getBreadcrumbs')),
        );
    }

    public function getBreadcrumbs()
    {
        return $this->container->get('symedit.breadcrumbs');
    }

    /**
     * This is used for things like generating meta descriptions from page content. We need
     * it to be plain text with no breaks. There is a limit which will truncate the text so
     * meta tags won't be filled with too much text.
     *
     * @param  string $text
     * @param  int    $limit
     * @return string
     */
    public function plain($text, $limit = null, $ellipsis = null)
    {
        $text = strip_tags($text);
        $text = htmlentities($text);
        $text = str_replace(array("\n", "\r"), ' ', $text);
        $text = preg_replace('#\s+#', ' ', $text);
        $len  = strlen($text);

        if (isset($limit) && is_int($limit) && $len > $limit) {
            $text = substr($text, 0, $limit);

            if ($ellipsis !== null) {
                $text .= $ellipsis;
            }
        }

        return $text;
    }

    /**
     * Check for existence of a route
     *
     * @param  string  $name Route Name
     * @return boolean
     */
    public function routeExists($name)
    {
        $router = $this->container->get('router');

        try {
            $router->generate($name);

            return true;
        } catch (MissingMandatoryParametersException $e) {
            return true;
        } catch (RouteNotFoundException $e) {
            return false;
        }
    }

    public function getName()
    {
        return 'SymEditBundleExtension';
    }
}
