<?php

namespace SymEdit\Bundle\AnalyticsBundle\Report;

use Doctrine\Common\Persistence\ObjectManager;

class Reporter
{
    protected $manager;
    protected $visitClass;
    protected $reports;

    public function __construct(ObjectManager $manager, $visitClass, array $reports = array())
    {
        $this->manager = $manager;
        $this->visitClass = $visitClass;
        $this->reports = $reports;
    }

    public function runReport($name, array $options = array())
    {
        $report = $this->getReport($name);
        $queryBuilder = $report->buildQuery($this->manager, $this->visitClass, $options);

        return $this->getReport($name)->runReport($queryBuilder, $options);
    }

    protected function getReport($name)
    {
        if (!array_key_exists($name, $this->reports)) {
            throw new \InvalidArgumentException(sprintf('Could not find report "%s".', $name));
        }
        
        return $this->reports[$name];
    }
}