<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Report\Extension;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface ReportExtensionInterface
{
    /**
     * Set more default options for a report.
     *
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver);

    /**
     * Build query for reports.
     *
     * @param QueryBuilder $queryBuilder
     * @param array        $options
     */
    public function buildQuery(QueryBuilder $queryBuilder, array $options);
}
