<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle;

use SymEdit\Bundle\ThemeBundle\DependencyInjection\SymEditThemeExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditThemeBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SymEditThemeExtension();
    }

    public function boot()
    {
        // Set template path
        $theme = $this->container->get('symedit_theme.theme');
        $loader = $this->container->get('twig.loader');

        $overrides = $this->container->getParameter('symedit_theme.namespace_overrides');

        if (!is_array($overrides)) {
            $overrides = array();
        }

        array_unshift($overrides, 'Theme');

        foreach (array_reverse($overrides) as $override) {
            $loader->prependPath($theme->getTemplateDirectory(), $override);
        }
    }
}
