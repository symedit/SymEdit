<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Template\Loader;

use SymEdit\Bundle\ThemeBundle\Model\Theme;

class ThemeTemplateLoader extends DirectoriesTemplateLoader
{
    public function __construct(Theme $theme)
    {
        $directories = array();

        foreach ($theme->getTemplateDirectories() as $directory) {
            $directories[] = sprintf('%s/Page', $directory);
        }

        parent::__construct($directories);
    }
}
