<?php

namespace SymEdit\Bundle\ThemeBundle\Stylizer\Storage;

use SymEdit\Bundle\StylizerBundle\Storage\YamlStorage;
use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;

class ThemeYamlStorage extends YamlStorage
{
    public function __construct(ThemeInterface $theme)
    {
        parent::__construct($theme->getThemeDirectory().'/colors.yml');
    }
}
