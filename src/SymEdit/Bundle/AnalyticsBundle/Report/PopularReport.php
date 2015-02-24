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

class PopularReport extends AbstractReport
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
        return parent::buildQuery($queryBuilder, $options)
            ->orderBy('visits', 'DESC')
            ->setMaxResults($options['max'])
        ;
    }

    public function getName()
    {
        return 'popular';
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'max' => 5,
        ));
    }
}
