<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler\WidgetFactoryCompilerPass;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler\WidgetVoterCompilerPass;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\SymEditWidgetExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditWidgetBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\WidgetBundle\Model';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new WidgetStrategyCompilerPass());
        $container->addCompilerPass(new WidgetVoterCompilerPass());
        $container->addCompilerPass(new WidgetFactoryCompilerPass());
    }

    protected function getBundlePrefix()
    {
        return 'symedit_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new SymEditWidgetExtension();
    }
}
