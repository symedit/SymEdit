<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\BlogBundle\DependencyInjection\SymEditBlogExtension;

class SymEditBlogBundle extends AbstractResourceBundle
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

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\BlogBundle\Model';
    }

    public function getContainerExtension()
    {
        return new SymEditBlogExtension();
    }
}
