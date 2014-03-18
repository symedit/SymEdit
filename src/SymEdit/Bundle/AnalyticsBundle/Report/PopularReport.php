<?php

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