<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\EventListener;

use SymEdit\Bundle\ThemeBundle\Event\Events;
use SymEdit\Bundle\ThemeBundle\Event\ThemeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TemplateLoaderSubscriber implements EventSubscriberInterface
{
    protected $loader;
    protected $namespaceOverrides;

    public function __construct(\Twig_Loader_Filesystem $loader, $namespaceOverrides)
    {
        $this->loader = $loader;
        $this->namespaceOverrides = $namespaceOverrides;
    }

    public function addTwigPaths(ThemeEvent $event)
    {
        $overrides = $this->namespaceOverrides;
        $theme = $event->getTheme();

        // Allow Theme namespace to access other namespaces
        foreach ($overrides as $override) {
            // Get paths we need to override
            $paths = $this->loader->getPaths($override);

            // For each path we find, allow @Theme to access it
            foreach ($paths as $path) {
                $this->loader->prependPath($path, 'Theme');
            }
        }

        // Make our theme templates override another namespace
        array_unshift($overrides, 'Theme');

        foreach (array_reverse($overrides) as $override) {
            $this->loader->prependPath($theme->getTemplateDirectory(), $override);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::THEME_BOOT => 'addTwigPaths'
        );
    }
}
