<?php

namespace SymEdit\Bundle\CoreBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigPathCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\IsometriksSymEditExtension;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\ProfileTypeCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class SymEditBundle extends Bundle
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

    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        );
    }

    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'SymEdit\Bundle\CoreBundle\Model\PageInterface'       => 'isometriks_symedit.model.page.class',
            'SymEdit\Bundle\CoreBundle\Model\PostInterface'       => 'isometriks_symedit.model.post.class',
            'SymEdit\Bundle\CoreBundle\Model\CategoryInterface'   => 'isometriks_symedit.model.category.class',
            'SymEdit\Bundle\CoreBundle\Model\SlideInterface'      => 'isometriks_symedit.model.slide.class',
            'SymEdit\Bundle\CoreBundle\Model\SliderInterface'     => 'isometriks_symedit.model.slider.class',
            'SymEdit\Bundle\CoreBundle\Model\WidgetAreaInterface' => 'isometriks_symedit.model.widget_area.class',
            'SymEdit\Bundle\CoreBundle\Model\WidgetInterface'     => 'isometriks_symedit.model.widget.class',
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
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\CoreBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new IsometriksSymEditExtension();
    }
}