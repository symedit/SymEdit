<?php

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

        $fallbacks = $this->container->getParameter('symedit_theme.fallback_bundles');

        if (!is_array($fallbacks)) {
            $fallbacks = array();
        }

        array_unshift($fallbacks, 'Theme');

        foreach (array_reverse($fallbacks) as $fallback) {
            $loader->prependPath($theme->getTemplateDirectory(), $fallback);
        }
    }
}
