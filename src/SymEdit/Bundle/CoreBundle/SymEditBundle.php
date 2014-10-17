<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\ProfileTypeCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\RouterLoaderCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\SymEditExtensionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigPathCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\SymEditExtension;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;

class SymEditBundle extends Bundle
{
    private $kernel;

    public function __construct(Kernel $kernel = null)
    {
        if ($kernel === null) {
            throw new \RuntimeException('When you register the SymEdit bundle, be sure to include "$this" in the parameters => '
                                      . 'new SymEdit\\Bundle\\CoreBundle\\SymEditBundle($this)');
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
            'SymEdit\Bundle\CoreBundle\Model\PageInterface'       => 'symedit.model.page.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('symedit', $interfaces));
        $container->addCompilerPass(new RouterLoaderCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass());
        $container->addCompilerPass(new TwigPathCompilerPass($this->kernel));
        $container->addCompilerPass(new ProfileTypeCompilerPass());
        $container->addCompilerPass(new SymEditExtensionCompilerPass());

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\CoreBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditExtension();
    }
}
