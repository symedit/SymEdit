<?php

namespace Isometriks\Bundle\SymEditBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TemplateGuesserCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigPathCompilerPass;

class IsometriksSymEditBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AnnotationLoaderCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass());
        $container->addCompilerPass(new TemplateGuesserCompilerPass());
        $container->addCompilerPass(new WidgetStrategyCompilerPass());
        $container->addCompilerPass(new TwigPathCompilerPass());
    }
}