<?php

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ProfileTypeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->removeDefinition('fos_user.profile.form.factory');
        $container->setAlias('fos_user.profile.form.factory', 'isometriks_symedit.form.factory.context');
    }
}