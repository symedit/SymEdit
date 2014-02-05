<?php

namespace SymEdit\Bundle\ThemeBundle\Factory\Resource;

use SymEdit\Bundle\ThemeBundle\Model\Theme;
use Assetic\Factory\Resource\DirectoryResource as BaseResource;

class DirectoryResource extends BaseResource
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;

        parent::__construct($theme->getTemplateDirectory());
    }
}