<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Compiler\ResolveDoctrineTargetEntitiesPass;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use SymEdit\Bundle\UserBundle\DependencyInjection\SymEditUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditUserBundle extends Bundle
{
    protected $loadProfiles;

    public function __construct($loadProfiles = true)
    {
        $this->loadProfiles = $loadProfiles;
    }

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
            'SymEdit\Bundle\CoreBundle\Model\UserInterface'    => 'symedit.model.user.class',
            'SymEdit\Bundle\CoreBundle\Model\ProfileInterface' => 'symedit.model.profile.class',
        );

        $container->addCompilerPass(new ResolveDoctrineTargetEntitiesPass('symedit_user', $interfaces));

        // Allow child bundle to do this
        if (!$this->loadProfiles) {
            return;
        }

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\UserBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditUserExtension();
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
