<?php

namespace Isometriks\Bundle\SeoBundle;

use Isometriks\Bundle\SeoBundle\DependencyInjection\Compiler\GetSeoCalculators;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IsometriksSeoBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $container->addCompilerPass(new GetSeoCalculators());
    }
}
