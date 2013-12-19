<?php

namespace Isometriks\Bundle\SymEditBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\TwigPathCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\IsometriksSymEditExtension;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\ProfileTypeCompilerPass;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\DoctrineMappingsPass;

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
        $interfaces = array(
            'Isometriks\Bundle\SymEditBundle\Model\UserInterface'       => 'isometriks_symedit.model.user.class',
            'Isometriks\Bundle\SymEditBundle\Model\ProfileInterface'    => 'isometriks_symedit.model.profile.class',
            'Isometriks\Bundle\SymEditBundle\Model\PageInterface'       => 'isometriks_symedit.model.page.class',
            'Isometriks\Bundle\SymEditBundle\Model\PostInterface'       => 'isometriks_symedit.model.post.class',
            'Isometriks\Bundle\SymEditBundle\Model\CategoryInterface'   => 'isometriks_symedit.model.category.class',
            'Isometriks\Bundle\SymEditBundle\Model\SlideInterface'      => 'isometriks_symedit.model.slide.class',
            'Isometriks\Bundle\SymEditBundle\Model\SliderInterface'     => 'isometriks_symedit.model.slider.class',
            'Isometriks\Bundle\SymEditBundle\Model\WidgetAreaInterface' => 'isometriks_symedit.model.widget_area.class',
            'Isometriks\Bundle\SymEditBundle\Model\WidgetInterface'     => 'isometriks_symedit.model.widget.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('isometriks_symedit', $interfaces));
        $container->addCompilerPass(new AnnotationLoaderCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass());
        $container->addCompilerPass(new WidgetStrategyCompilerPass());
        $container->addCompilerPass(new TwigPathCompilerPass($this->kernel));
        $container->addCompilerPass(new ProfileTypeCompilerPass());

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'Isometriks\Bundle\SymEditBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new IsometriksSymEditExtension();
    }
}