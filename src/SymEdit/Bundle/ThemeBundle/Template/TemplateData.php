<?php

namespace SymEdit\Bundle\ThemeBundle\Template;

use SymEdit\Bundle\ThemeBundle\Model\Template;

class TemplateData
{
    protected $templates = array();

    public function addTemplate(Template $template)
    {
        $this->templates[$template->getKey()] = $template;
    }

    public function getTemplates()
    {
        return $this->templates;
    }
}