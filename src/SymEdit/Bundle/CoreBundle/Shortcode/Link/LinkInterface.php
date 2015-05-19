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

use Symfony\Component\Routing\RouterInterface;

interface LinkInterface
{
    /**
     * Check to see if this link can return a route.
     *
     * @param array $attributes
     */
    public function supports(array $attributes);

    public function generate(RouterInterface $router, array $attributes);
}
