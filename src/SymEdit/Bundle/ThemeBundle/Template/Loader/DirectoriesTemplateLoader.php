<?php

namespace SymEdit\Bundle\ThemeBundle\Template\Loader;

use SymEdit\Bundle\ThemeBundle\Template\TemplateData;

class DirectoriesTemplateLoader implements TemplateLoaderInterface
{
    protected $directories;

    public function __construct($directories = array())
    {
        $this->directories = $directories;
    }

    public function loadTemplateData(TemplateData $templateData)
    {
        foreach ($this->directories as $directory) {
            $loader = new DirectoryTemplateLoader($directory);
            $loader->loadTemplateData($templateData);
        }
    }
}