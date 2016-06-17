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
use SymEdit\Bundle\BlogBundle\Model\PostInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PopularPostReport extends PopularReport
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options)
    {
        $qb = parent::buildQuery($queryBuilder, $options);

        if ($options['published']) {
            $qb
                ->andWhere('c.status = :status')
                ->setParameter('status', PostInterface::PUBLISHED)
            ;
        }

        return $qb;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'published' => true,
            'model' => 'post',
        ]);
    }

    public function getName()
    {
        return 'popular_posts';
    }
}
