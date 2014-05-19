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
    public function __construct($bundle, KernelInterface $kernel, $type = 'Page')
    {
        $directories = $kernel->locateResource(sprintf('@%s/Resources/views/%s', $bundle, $type), null, false);

        parent::__construct(array_reverse($directories));
    }
}
