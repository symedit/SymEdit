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

use SymEdit\Bundle\ThemeBundle\DependencyInjection\Compiler\TemplateLoaderPass;
use SymEdit\Bundle\ThemeBundle\DependencyInjection\Compiler\TemplateResourcesPass;
use SymEdit\Bundle\ThemeBundle\DependencyInjection\Compiler\ThemeLoaderPass;
use SymEdit\Bundle\ThemeBundle\DependencyInjection\Compiler\TwigLoaderPass;
use SymEdit\Bundle\ThemeBundle\DependencyInjection\SymEditThemeExtension;
use SymEdit\Bundle\ThemeBundle\Event\Events;
use SymEdit\Bundle\ThemeBundle\Event\ThemeEvent;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditThemeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TemplateResourcesPass());
        $container->addCompilerPass(new TemplateLoaderPass());
        $container->addCompilerPass(new ThemeLoaderPass());
        $container->addCompilerPass(new TwigLoaderPass());
    }

    public function boot()
    {
        // Send event for theme boot
        $theme = $this->container->get('symedit_theme.theme');

        $event = new ThemeEvent($theme);
        $this->container->get('event_dispatcher')->dispatch(Events::THEME_BOOT, $event);
    }

    public function getContainerExtension()
    {
        return new SymEditThemeExtension();
    }
}
