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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractReport implements ReportInterface
{
    public function buildQuery(ObjectManager $manager, $visitClass, $options = array())
    {
        $class = $this->getClass($options);
        $qb = $manager->createQueryBuilder()
                ->select('c AS object, COUNT(v) AS visits')
                ->from($class, 'c')
                ->leftJoin($visitClass, 'v', 'WITH', 'c.id = v.identifier AND v.class = :class')
                ->groupBy('v.identifier')
                ->setParameter('class', $class)
        ;

        return $qb;
    }

    public function runReport(QueryBuilder $queryBuilder, array $options = array())
    {
        return $queryBuilder->getQuery()->getResult();
    }

    public function getClass(array $options = array())
    {
        $class = $this->getOption($options, 'class');

        if ($class === null) {
            throw new \InvalidArgumentException('Please provide a "class" option or override getClass() in your report');
        }

        return $options['class'];
    }

    public function getOption(array $options, $option, $default = null)
    {
        return isset($options[$option]) ? $options[$option] : $default;
    }
}