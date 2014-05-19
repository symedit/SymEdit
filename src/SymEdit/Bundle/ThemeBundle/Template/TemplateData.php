<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
