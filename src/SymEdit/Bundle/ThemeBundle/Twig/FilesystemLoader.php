<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Twig;

use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader as BaseFilesystemLoader;

class FilesystemLoader extends BaseFilesystemLoader
{
    public function setThemePaths(ThemeInterface $theme, array $overrides = [])
    {
        // Allow Theme namespace to access other namespaces
        foreach ($overrides as $override) {
            // Get paths we need to override
            $paths = $this->getPaths($override);

            // For each path we find, allow @Theme to access it
            $this->prependPaths($paths, 'Theme');
        }

        // Get Directories
        $templateDirectories = array_reverse($theme->getTemplateDirectories());

        // Setup the Theme Template Paths
        $this->prependPaths($templateDirectories, 'Theme');

        // Setup overrides (So when you call @MyNamespace it will call the theme templates instead)
        foreach ($overrides as $override) {
            $this->prependPaths($templateDirectories, $override);
        }

        // Create @Parent namespace, don't include the current theme
        $themeDirectory = $theme->getTemplateDirectories(true);

        $parentDirectories = array_filter($templateDirectories, function ($directory) use ($themeDirectory) {
            return $themeDirectory !== $directory;
        });

        $this->prependPaths($parentDirectories, 'Parent');
    }

    protected function prependPaths(array $paths, $namespace = self::MAIN_NAMESPACE)
    {
        foreach ($paths as $path) {
            $this->prependPath($path, $namespace);
        }
    }
}
