<?php

namespace SymEdit\Bundle\WidgetBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\SymEditWidgetExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditWidgetBundle extends Bundle
{
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        );
    }

    public function build(ContainerBuilder $container)
    {
        $interfaces = array(
            'SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface' => 'symedit.model.widget_area.class',
            'SymEdit\Bundle\WidgetBundle\Model\WidgetInterface'     => 'symedit.model.widget.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('symedit_widget', $interfaces));
        $container->addCompilerPass(new WidgetStrategyCompilerPass());

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\WidgetBundle\Model',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new SymEditWidgetExtension();
    }
}
