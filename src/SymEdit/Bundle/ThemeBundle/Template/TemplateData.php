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
    protected $templates = [];

    public function addTemplate(Template $template)
    {
        $type = $template->getType();

        // Don't add templates with no type aka, no subfolder
        if ($type === null) {
            return;
        }

        if (!isset($this->templates[$type])) {
            $this->template[$type] = [];
        }

        $this->templates[$type][$template->getKey()] = $template;
    }

    public function getTemplates($type)
    {
        return isset($this->templates[$type]) ? $this->templates[$type] : [];
    }
}
