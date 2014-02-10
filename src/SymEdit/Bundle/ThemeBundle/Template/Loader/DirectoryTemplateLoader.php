<?php

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
        $finder = new Finder();
        $finder->files()->in($this->directory)->name('*.html.twig');

        foreach ($finder as $template) {
            $templateData->addTemplate(new Template($template->getRelativePathName(), $template->getPathName()));
        }
    }
}