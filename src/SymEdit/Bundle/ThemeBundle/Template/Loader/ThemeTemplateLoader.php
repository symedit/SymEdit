<?php

namespace SymEdit\Bundle\ThemeBundle\Template\Loader;

use SymEdit\Bundle\ThemeBundle\Model\Theme;

class ThemeTemplateLoader extends DirectoryTemplateLoader
{
    public function __construct(Theme $theme)
    {
        parent::__construct(sprintf('%s/Page', $theme->getTemplateDirectory()));
    }
}