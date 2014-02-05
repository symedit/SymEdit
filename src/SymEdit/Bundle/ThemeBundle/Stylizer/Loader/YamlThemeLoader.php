<?php

namespace SymEdit\Bundle\ThemeBundle\Stylizer\Loader;

use SymEdit\Bundle\StylizerBundle\Loader\YamlLoader;
use SymEdit\Bundle\ThemeBundle\Model\Theme;

class YamlThemeLoader extends YamlLoader
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;

        $yamlFiles = array();
        $styles = sprintf('%s/%s.yml', $theme->getThemeDirectory(), 'styles');

        if (file_exists($styles)) {
            $yamlFiles[] = $styles;
        }

        parent::__construct($yamlFiles);
    }
}