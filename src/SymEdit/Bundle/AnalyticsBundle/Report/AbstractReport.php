<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Report;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractReport implements ReportInterface
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
        return $queryBuilder
            ->select('c AS object, COUNT(v) AS visits')
            ->from($options['class'], 'c')
            ->leftJoin($options['visitClass'], 'v', 'WITH', 'c.id = v.identifier AND v.model = :model')
            ->groupBy('v.identifier')
            ->setParameters([
                'model' => $options['model'],
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
    }
}
