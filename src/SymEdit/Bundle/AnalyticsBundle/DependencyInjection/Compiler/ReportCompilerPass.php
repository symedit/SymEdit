<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ReportCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // Get reports
        $tags = $container->findTaggedServiceIds('symedit_analytics.report');
        $reports = [];

        foreach ($tags as $id => $tags) {
            foreach ($tags as $attr) {
                if (!isset($attr['alias'])) {
                    throw new \InvalidArgumentException(sprintf('Missing "alias" for report for service id "%s"', $id));
                }

                $reports[$attr['alias']] = new Reference($id);
            }
        }

        // Get Extensions
        $tags = $container->findTaggedServiceIds('symedit_analytics.report_extension');
        $extensions = [];

        foreach ($tags as $id => $tags) {
            $extensions[] = new Reference($id);
        }

        $reporterDefinition = $container->getDefinition('symedit_analytics.reporter');
        $reporterDefinition->replaceArgument(3, $reports);
        $reporterDefinition->replaceArgument(4, $extensions);
    }
}
