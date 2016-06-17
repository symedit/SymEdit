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

class MaxResultReportExtension extends AbstractReportExtension
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
        if ($options['max'] !== null) {
            $queryBuilder
                ->setMaxResults($options['max'])
            ;
        }
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'max' => null,
        ]);

        $resolver->setAllowedTypes('max', ['null', 'int']);
    }
}
