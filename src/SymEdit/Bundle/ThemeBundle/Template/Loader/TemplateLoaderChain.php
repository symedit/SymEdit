<?php

namespace SymEdit\Bundle\ThemeBundle\Template\Loader;

use SymEdit\Bundle\ThemeBundle\Template\TemplateData;

class TemplateLoaderChain implements TemplateLoaderInterface
{
    protected $loaders = array();

    public function __construct($loaders = array())
    {
        $this->loaders = $loaders;
    }

    public function loadTemplateData(TemplateData $templateData)
    {
        foreach ($this->loaders as $loader) {
            $loader->loadTemplateData($templateData);
        }
    }
}