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

class ThemeTemplateLoader extends DirectoryTemplateLoader
{
    public function __construct(Theme $theme)
    {
        parent::__construct(sprintf('%s/Page', $theme->getTemplateDirectory()));
    }
}