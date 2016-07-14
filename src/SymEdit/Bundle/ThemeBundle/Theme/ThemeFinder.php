<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Theme;

use Symfony\Component\Finder\Finder;

class ThemeFinder
{
    protected $themeDir;

    public function __construct($themeDir)
    {
        $this->themeDir = $themeDir;
    }

    public function findThemeNames()
    {
        $finder = new Finder();
        $finder
            ->directories()
            ->in($this->themeDir)
            ->depth(0)
        ;

        $names = [];

        foreach ($finder as $directory) {
            $names[] = $directory->getFilename();
        }

        return $names;
    }
}
