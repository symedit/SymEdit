<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Stylizer\Loader;

use SymEdit\Bundle\StylizerBundle\Loader\YamlLoader;
use SymEdit\Bundle\ThemeBundle\Model\Theme;

class YamlThemeLoader extends YamlLoader
{
    public function __construct(Theme $theme)
    {
        $yamlFiles = [];

        while ($theme !== null) {
            $styles = sprintf('%s/%s.yml', $theme->getThemeDirectory(), 'styles');

            if (file_exists($styles)) {
                $yamlFiles[] = $styles;
            }

            $theme = $theme->getParentTheme();
        }

        parent::__construct(array_reverse($yamlFiles));
    }
}
