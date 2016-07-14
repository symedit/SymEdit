<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\EventsBundle\DependencyInjection\SymEditEventsExtension;

class SymEditEventsBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\EventsBundle\Model';
    }

    protected function getBundlePrefix()
    {
        return 'symedit_events';
    }

    public function getContainerExtension()
    {
        return new SymEditEventsExtension();
    }
}
