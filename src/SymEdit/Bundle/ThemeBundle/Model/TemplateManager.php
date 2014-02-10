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