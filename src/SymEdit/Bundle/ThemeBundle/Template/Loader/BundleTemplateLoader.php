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

use Symfony\Component\HttpKernel\KernelInterface;

class BundleTemplateLoader extends DirectoriesTemplateLoader
{
    protected $bundle;
    protected $kernel;

    public function __construct($bundle, KernelInterface $kernel)
    {
        $this->bundle = $bundle;
        $this->kernel = $kernel;
    }

    protected function getDirectories()
    {
        $location = sprintf('@%s/Resources/views', $this->bundle);
        $directories = $this->kernel->locateResource($location, null, false);

        return array_reverse($directories);
    }
}
