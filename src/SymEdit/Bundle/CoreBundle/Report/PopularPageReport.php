<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Report;

use Doctrine\ORM\QueryBuilder;
use SymEdit\Bundle\AnalyticsBundle\Report\PopularReport;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PopularPageReport extends PopularReport
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
        parent::buildQuery($queryBuilder, $options)
            ->andWhere('c.root = false')
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'model' => 'page',
        ]);
    }

    public function getName()
    {
        return 'popular_pages';
    }
}
