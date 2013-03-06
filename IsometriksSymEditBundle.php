<?php

namespace Isometriks\Bundle\SymEditBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass; 
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass; 
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\EditableExtensionCompilerPass;  

class IsometriksSymEditBundle extends Bundle 
{    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AnnotationLoaderCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass()); 
        $container->addCompilerPass(new EditableExtensionCompilerPass());
    }
}