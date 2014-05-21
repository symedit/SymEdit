<?php

namespace SymEdit\Bundle\CoreBundle\Shortcode;

use SymEdit\Bundle\ShortcodeBundle\Shortcode\AbstractShortcode;
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

        if (array_key_exists($route, $this->router->getRouteCollection()->all())) {
            return $this->router->generate($route);
        } else {
            return $match;
        }
    }

    public function getName()
    {
        return 'link';
    }
}