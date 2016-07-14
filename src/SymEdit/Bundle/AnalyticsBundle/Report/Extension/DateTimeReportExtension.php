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

class DateTimeReportExtension extends AbstractReportExtension
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
        if ($options['date_start'] !== null) {
            $queryBuilder
                ->andWhere('v.visitDate >= :date_start')
                ->setParameter('date_start', $options['date_start'])
            ;
        }

        if ($options['date_end'] !== null) {
            $queryBuilder
                ->andWhere('v.visitDate <= :date_end')
                ->setParameter('date_end', $options['date_end'])
            ;
        }
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'date_start' => null,
            'date_end' => null,
        ]);
    }
}
