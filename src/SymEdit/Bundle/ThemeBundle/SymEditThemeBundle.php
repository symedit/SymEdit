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
