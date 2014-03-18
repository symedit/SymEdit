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

use SymEdit\Bundle\AnalyticsBundle\DependencyInjection\Compiler\ReportCompilerPass;
use SymEdit\Bundle\AnalyticsBundle\DependencyInjection\SymEditAnalyticsExtension;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditAnalyticsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ReportCompilerPass());

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\AnalyticsBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditAnalyticsExtension();
    }
}
