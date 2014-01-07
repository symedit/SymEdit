<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Finder;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Finder\Finder;

/**
 * @todo Refactor this to TemplateFinder or something..
 */
class ResourceFinder
{
    private $kernel;

    public function __construct(HttpKernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Get all bundles that are, or extend SymEditBundle and start with the
     * ancestors. As we get down to the actual bundle it should overwrite
     * any ancestor template.
     *
     * @param type $type
     * @return type
     */
    public function getTemplates($type = 'Page')
    {
        $dirs = $this->kernel->locateResource('@SymEditBundle/Resources/views/'.$type, null, false);
        $dirs = array_reverse($dirs);

        $templates = array();

        foreach ($dirs as $dir) {
            foreach($this->getTemplatesFromDir($dir) as $template) {
                $templates[$template->getRelativePathname()] = $template;
            }
        }

        return $templates;
    }

    protected function getTemplatesFromDir($dir)
    {
        $finder = new Finder();
        $files = $finder->in($dir)->files()->name('*.twig');

        return $files;
    }
}