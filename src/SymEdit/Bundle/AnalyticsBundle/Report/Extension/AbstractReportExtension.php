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

class AbstractReportExtension implements ReportExtensionInterface
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
    }
}
