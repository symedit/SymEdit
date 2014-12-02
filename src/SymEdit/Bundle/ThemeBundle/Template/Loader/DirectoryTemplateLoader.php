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

use SymEdit\Bundle\ThemeBundle\Model\Template;
use SymEdit\Bundle\ThemeBundle\Template\TemplateData;
use Symfony\Component\Finder\Finder;

class DirectoryTemplateLoader implements TemplateLoaderInterface
{
    protected $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    public function loadTemplateData(TemplateData $templateData)
    {
        if (!is_dir($this->directory)) {
            return;
        }

        $finder = new Finder();
        $finder->files()->in($this->directory)->name('*.html.twig');

        foreach ($finder as $template) {
            $templateData->addTemplate(new Template($template->getRelativePathName(), $template->getPathName()));
        }
    }
}
