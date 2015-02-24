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

interface ReportInterface
{
    public function buildQuery(QueryBuilder $queryBuilder, array $options);

    public function setDefaultOptions(OptionsResolver $resolver);

    public function getName();
}
