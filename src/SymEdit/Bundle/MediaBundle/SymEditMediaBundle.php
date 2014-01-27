<?php

namespace SymEdit\Bundle\MediaBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\MediaBundle\DependencyInjection\SymEditMediaExtension;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditMediaBundle extends Bundle
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
            'SymEdit\Bundle\MediaBundle\Model\ImageInterface' => 'symedit.model.image.class',
            'SymEdit\Bundle\MediaBundle\Model\FileInterface' => 'symedit.model.file.class',
            'SymEdit\Bundle\MediaBundle\Model\ImageGalleryInterface' => 'symedit.model.image_gallery.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('symedit', $interfaces));

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\MediaBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditMediaExtension();
    }
}
