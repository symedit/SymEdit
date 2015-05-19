<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Command;

use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Finder\Finder;

abstract class AbstractThemeCommand extends ContainerAwareCommand
{
    /**
     * Get a theme, or current them with no name.
     *
     * @param string $name
     *
     * @return ThemeInterface
     */
    protected function getTheme($name = null)
    {
        if ($name === null) {
            return $this->getContainer()->get('symedit_theme.theme');
        }

        return $this->getContainer()->get('symedit_theme.theme_manager')->getTheme($name);
    }

    /**
     * @return Finder
     */
    protected function getTemplateFinder()
    {
        $finder = new Finder();
        $finder->in($this->getTheme()->getTemplateDirectories());

        return $finder;
    }

    protected function getTemplateSource($name)
    {
        /* @var $loader \Twig_LoaderInterface */
        $loader = $this->getContainer()->get('twig.loader');

        return $loader->getSource($name);
    }
}
