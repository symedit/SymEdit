<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\FormBuilderBundle\DependencyInjection\Compiler\FieldBuilderCompilerPass;
use SymEdit\Bundle\FormBuilderBundle\DependencyInjection\Compiler\FormElementFactoryCompilerPass;
use SymEdit\Bundle\FormBuilderBundle\DependencyInjection\SymEditFormBuilderExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditFormBuilderBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\FormBuilderBundle\Model';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FieldBuilderCompilerPass());
        $container->addCompilerPass(new FormElementFactoryCompilerPass());
    }

    public function getContainerExtension()
    {
        return new SymEditFormBuilderExtension();
    }

    protected function getBundlePrefix()
    {
        return 'symedit_form_builder';
    }
}
