<?php

namespace Isometriks\Bundle\SymEditBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigPathCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\IsometriksSymEditExtension;

class IsometriksSymEditBundle extends Bundle
{
    private $kernel;

    public function __construct(Kernel $kernel = null)
    {
        if($kernel === null) {
            throw new \RuntimeException('When you register the SymEdit bundle, be sure to include "$this" in the parameters => '
                                      . 'new Isometriks\\Bundle\\SymEditBundle\\IsometriksSymEditBundle($this)');
        }

        $this->kernel = $kernel;
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AnnotationLoaderCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass());
        $container->addCompilerPass(new WidgetStrategyCompilerPass());
        $container->addCompilerPass(new TwigPathCompilerPass($this->kernel));
    }

    public function getContainerExtension()
    {
        return new IsometriksSymEditExtension();
    }
}