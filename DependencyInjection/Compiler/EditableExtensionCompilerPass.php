<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EditableExtensionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definitions = array_keys($container->findTaggedServiceIds('symedit.editable.extension')); 
        $container->setParameter('isometriks_sym_edit.editable.extensions', $definitions); 
    }
}