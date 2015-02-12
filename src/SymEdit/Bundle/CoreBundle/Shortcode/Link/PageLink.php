<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Shortcode\Link;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class PageLink implements LinkInterface
{
    public function supports(array $attributes)
    {
        return isset($attributes['page-id']);
    }

    public function generate(RouterInterface $router, array $attributes)
    {
        try {
            return $router->generate(sprintf('page/%d', (int) $attributes['page-id']));
        } catch (RouteNotFoundException $e) {
            return;
        }
    }
}
