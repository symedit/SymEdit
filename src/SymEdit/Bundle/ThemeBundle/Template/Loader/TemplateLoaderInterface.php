<?php

namespace SymEdit\Bundle\ThemeBundle\Template\Loader;

use SymEdit\Bundle\ThemeBundle\Template\TemplateData;

interface TemplateLoaderInterface
{
    public function loadTemplateData(TemplateData $templateData);
}