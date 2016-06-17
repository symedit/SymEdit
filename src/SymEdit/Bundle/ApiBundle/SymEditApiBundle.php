<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ApiBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\ApiBundle\DependencyInjection\SymEditApiExtension;

class SymEditApiBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    protected function getBundlePrefix()
    {
        return 'symedit_blog';
    }

    protected function getModelInterfaces()
    {
        return [
            'SymEdit\Bundle\ApiBundle\Model\AccessTokenInterface' => 'symedit.model.access_token.class',
            'SymEdit\Bundle\ApiBundle\Model\AuthCodeInterface' => 'symedit.model.auth_code.class',
            'SymEdit\Bundle\ApiBundle\Model\ClientInterface' => 'symedit.model.client.class',
            'SymEdit\Bundle\ApiBundle\Model\RefreshTokenInterface' => 'symedit.model.refresh_token.class',
        ];
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\ApiBundle\Model';
    }

    public function getContainerExtension()
    {
        return new SymEditApiExtension();
    }
}
