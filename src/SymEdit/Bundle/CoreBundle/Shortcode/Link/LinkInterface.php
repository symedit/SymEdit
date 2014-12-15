<?php

namespace SymEdit\Bundle\CoreBundle\Shortcode\Link;

use Symfony\Component\Routing\RouterInterface;

interface LinkInterface
{
    /**
     * Check to see if this link can return a route
     *
     * @param array $attributes
     */
    public function supports(array $attributes);

    public function generate(RouterInterface $router, array $attributes);
}