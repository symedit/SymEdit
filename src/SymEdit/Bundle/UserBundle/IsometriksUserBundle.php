<?php

namespace Isometriks\Bundle\UserBundle;

use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IsometriksUserBundle extends Bundle
{
    public static function getSupportedDrivers()
    {
        return array(
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        );
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $interfaces = array(
            'SymEdit\Bundle\CoreBundle\Model\UserInterface'    => 'isometriks_symedit.model.user.class',
            'SymEdit\Bundle\CoreBundle\Model\ProfileInterface' => 'isometriks_symedit.model.profile.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('isometriks_user', $interfaces));

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'Isometriks\Bundle\UserBundle\Model',
        ));
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}