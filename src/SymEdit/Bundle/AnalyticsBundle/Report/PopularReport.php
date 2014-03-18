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

class PopularReport extends AbstractReport
{
    public function buildQuery(ObjectManager $manager, $visitClass, $options = array())
    {
        $max = $this->getOption($options, 'max', 5);

        return parent::buildQuery($manager, $visitClass, $options)
                ->orderBy('visits', 'DESC')
                ->setMaxResults($max);
    }

    public function getName()
    {
        return 'popular';
    }
}