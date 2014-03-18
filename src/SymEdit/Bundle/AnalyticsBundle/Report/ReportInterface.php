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

interface ReportInterface
{
    public function buildQuery(ObjectManager $manager, $visitClass, $options = array());

    public function runReport(QueryBuilder $queryBuilder, array $options = array());

    public function getClass(array $options = array());

    public function getName();
}