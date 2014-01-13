<?php

namespace SymEdit\Bundle\SitemapBundle;

use SymEdit\Bundle\SitemapBundle\DependencyInjection\SymEditSitemapExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSitemapBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SymEditSitemapExtension();
    }
}
