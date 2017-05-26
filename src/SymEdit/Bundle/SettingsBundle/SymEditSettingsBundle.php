<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\SettingsBundle\DependencyInjection\Compiler\RegisterResolversPass;
use SymEdit\Bundle\SettingsBundle\DependencyInjection\Compiler\RegisterSchemasPass;
use SymEdit\Bundle\SettingsBundle\DependencyInjection\SymEditSettingsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class SymEditSettingsBundle extends AbstractResourceBundle
{
    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterSchemasPass());
        $container->addCompilerPass(new RegisterResolversPass());
    }

    protected function getBundlePrefix()
    {
        return 'symedit_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\SettingsBundle\Model';
    }

    public function getContainerExtension()
    {
        return new SymEditSettingsExtension();
    }
}
