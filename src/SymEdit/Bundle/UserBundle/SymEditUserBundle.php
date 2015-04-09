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

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\UserBundle\DependencyInjection\Compiler\ProfileTypeCompilerPass;
use SymEdit\Bundle\UserBundle\DependencyInjection\SymEditUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditUserBundle extends AbstractResourceBundle
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

        $container->addCompilerPass(new ProfileTypeCompilerPass());
    }

    protected function getModelInterfaces()
    {
        return array(
            'SymEdit\Bundle\UserBundle\Model\UserInterface'    => 'symedit.model.user.class',
            'SymEdit\Bundle\UserBundle\Model\ProfileInterface' => 'symedit.model.profile.class',
        );
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\UserBundle\Model';
    }

    public function getContainerExtension()
    {
        return new SymEditUserExtension();
    }

    protected function getBundlePrefix()
    {
        return 'symedit_user';
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
