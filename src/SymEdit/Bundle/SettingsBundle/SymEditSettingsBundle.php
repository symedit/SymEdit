<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle;

use SymEdit\Bundle\SettingsBundle\DependencyInjection\Compiler\SettingsLoaderPass;
use SymEdit\Bundle\SettingsBundle\DependencyInjection\SymEditSettingsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSettingsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SettingsLoaderPass());
    }

    public function getContainerExtension()
    {
        return new SymEditSettingsExtension();
    }
}
