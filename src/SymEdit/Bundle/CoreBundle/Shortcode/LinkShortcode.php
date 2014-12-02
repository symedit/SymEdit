<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
            $route = 'page/'.$attr['page-id'];
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
