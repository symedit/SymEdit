<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

    public function getTemplates($directory)
    {
        return $this->getTemplateData()->getTemplates($directory);
    }

    public function getTemplateTree($directory)
    {
        $tree = [];

        $templates = $this->getTemplates($directory);
        ksort($templates);

        foreach ($templates as $template) {
            $this->addToTree($tree, $template);
        }

        return $tree;
    }

    protected function addToTree(&$tree, TemplateInterface $template)
    {
        $location = &$tree;
        $parts = explode('/', $template->getKey());

        // Remove template name
        array_pop($parts);

        if (count($parts) === 0) {
            array_unshift($parts, 'Default');
        }

        foreach ($parts as $part) {
            if (!isset($location[$part])) {
                $location[$part] = [];
            }

            $location = &$location[$part];
        }

        $location[$template->getKey()] = $template;
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
