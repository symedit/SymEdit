<?php

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