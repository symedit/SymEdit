<?php

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