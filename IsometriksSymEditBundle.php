<?php

namespace Isometriks\Bundle\SymEditBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass;  
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\EditableExtensionCompilerPass;  
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass; 

class IsometriksSymEditBundle extends Bundle 
{    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AnnotationLoaderCompilerPass());
        $container->addCompilerPass(new EditableExtensionCompilerPass());
        //$container->addCompilerPass(new TwigExceptionCompilerPass()); 
    }
}