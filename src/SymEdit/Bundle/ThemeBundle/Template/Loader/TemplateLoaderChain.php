<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Template\Loader;

use SymEdit\Bundle\ThemeBundle\Template\TemplateData;

class TemplateLoaderChain implements TemplateLoaderInterface
{
    protected $loaders = [];

    public function __construct($loaders = [])
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
