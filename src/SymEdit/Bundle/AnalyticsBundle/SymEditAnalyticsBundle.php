<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\AnalyticsBundle\DependencyInjection\Compiler\ReportCompilerPass;
use SymEdit\Bundle\AnalyticsBundle\DependencyInjection\SymEditAnalyticsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditAnalyticsBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ReportCompilerPass());
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\AnalyticsBundle\Model';
    }

    public function getContainerExtension()
    {
        return new SymEditAnalyticsExtension();
    }

    protected function getBundlePrefix()
    {
        return 'symedit_analytics';
    }
}
