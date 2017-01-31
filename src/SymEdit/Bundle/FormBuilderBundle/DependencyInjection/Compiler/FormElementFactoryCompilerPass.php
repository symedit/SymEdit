<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\DependencyInjection\Compiler;

use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

class FormElementFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $defaultFactoryDefinition = new Definition(
            Factory::class,
            [
                new Parameter('symedit.model.form_element.class'),
            ]
        );

        $formElementFactoryDefinition = new Definition(
            $container->getParameter('symedit.factory.form_element.class'),
            [
                $defaultFactoryDefinition,
                new Reference('symedit.repository.form_builder'),
            ]
        );

        $container->setDefinition('symedit.factory.form_element', $formElementFactoryDefinition);
    }
}
