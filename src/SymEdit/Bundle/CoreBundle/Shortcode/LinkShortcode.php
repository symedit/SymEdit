<?php

namespace SymEdit\Bundle\CoreBundle\Shortcode;

use SymEdit\Bundle\ShortcodeBundle\Shortcode\AbstractShortcode;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class LinkShortcode extends AbstractShortcode
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function renderShortcode($match, array $attr, $content)
    {
        if (isset($attr['page-id'])) {
            $route = 'page_' . $attr['page-id'];
        } else {
            return $match;
        }

        try {
            $out = $this->router->generate($route);
        } catch (RouteNotFoundException $e) {
            $out = $match;
        }

        return $out;
    }

    public function getName()
    {
        return 'link';
    }
}