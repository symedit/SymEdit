<?php

namespace SymEdit\Bundle\CacheBundle;

use SymEdit\Bundle\CacheBundle\DependencyInjection\Compiler\AddCacheVotersPass;
use SymEdit\Bundle\CacheBundle\DependencyInjection\SymEditCacheExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditCacheBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddCacheVotersPass());
    }

    public function getContainerExtension()
    {
        return new SymEditCacheExtension();
    }
}
