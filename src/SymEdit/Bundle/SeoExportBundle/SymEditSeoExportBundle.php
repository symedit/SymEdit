<?php

namespace SymEdit\Bundle\SeoExportBundle;

use SymEdit\Bundle\SeoExportBundle\DependencyInjection\SymEditSeoExportExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSeoExportBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new SymEditSeoExportExtension();
    }
}
