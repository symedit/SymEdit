<?php

namespace Isometriks\Bundle\StylizerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder; 
use Isometriks\Bundle\StylizerBundle\DependencyInjection\Compiler\InjectorCompilerPass; 

class IsometriksStylizerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InjectorCompilerPass()); 
    }
    
    public function getParent()
    {
        return 'AsseticBundle'; 
    }
}
