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
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\AnnotationLoaderCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigPathCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\SymEditExtension;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\ProfileTypeCompilerPass;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class SymEditBundle extends Bundle
{
    private $kernel;

    public function __construct(Kernel $kernel = null)
    {
        if($kernel === null) {
            throw new \RuntimeException('When you register the SymEdit bundle, be sure to include "$this" in the parameters => '
                                      . 'new Isometriks\\Bundle\\SymEditBundle\\SymEditBundle($this)');
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
            'SymEdit\Bundle\CoreBundle\Model\SlideInterface'      => 'symedit.model.slide.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('symedit', $interfaces));
        $container->addCompilerPass(new AnnotationLoaderCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass());
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
        return new SymEditExtension();
    }
}