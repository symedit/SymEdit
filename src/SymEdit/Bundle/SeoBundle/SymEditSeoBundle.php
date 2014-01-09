<?php

namespace SymEdit\Bundle\SeoBundle;

use SymEdit\Bundle\SeoBundle\DependencyInjection\Compiler\GetSeoCalculators;
use SymEdit\Bundle\SeoBundle\DependencyInjection\SymEditSeoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSeoBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GetSeoCalculators());
    }

    public function getContainerExtension()
    {
        return new SymEditSeoExtension();
    }
}
