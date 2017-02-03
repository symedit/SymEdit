<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MailerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $messages = $this->getServices($container, 'symedit.mailer.message', true);
        $extensions = $this->getServices($container, 'symedit.mailer.extension', false);

        $mailerDefinition = $container->getDefinition('symedit.mailer');
        $mailerDefinition->replaceArgument(1, $messages);
        $mailerDefinition->replaceArgument(2, $extensions);
    }

    private function getServices(ContainerBuilder $container, $tagName, $useAlias)
    {
        $services = [];

        foreach ($container->findTaggedServiceIds($tagName) as $id => $tags) {
            if (!$useAlias) {
                $services[] = new Reference($id);

                continue;
            }

            if (!isset($tags[0]['alias'])) {
                throw new \InvalidArgumentException(sprintf('Services tagged with "%s" need an "alias"', $tagName));
            }

            $alias = $tags[0]['alias'];
            $services[$alias] = new Reference($id);
        }

        return $services;
    }
}
