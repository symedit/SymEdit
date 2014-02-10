<?php

namespace SymEdit\Bundle\ThemeBundle\Model;

use SymEdit\Bundle\ThemeBundle\Template\Loader\TemplateLoaderInterface;
use SymEdit\Bundle\ThemeBundle\Template\TemplateData;

class TemplateManager
{
    protected $loader;
    protected $templateData;

    public function __construct(TemplateLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function getTemplates()
    {
        return $this->getTemplateData()->getTemplates();
    }
    
    /**
     * @return TemplateData
     */
    protected function getTemplateData()
    {
        if ($this->templateData === null) {
            $this->templateData = new TemplateData();
            $this->loader->loadTemplateData($this->templateData);
        }

        return $this->templateData;
    }
}