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
use SymEdit\Bundle\AnalyticsBundle\Exception\InvalidReportException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Reporter implements ReporterInterface
{
    protected $manager;
    protected $visitClass;
    protected $models;
    protected $reports;
    protected $extensions;

    public function __construct(ObjectManager $manager, $visitClass, array $models, array $reports = [], array $extensions = [])
    {
        $this->manager = $manager;
        $this->visitClass = $visitClass;
        $this->models = $models;
        $this->reports = $reports;
        $this->extensions = $extensions;
    }

    public function runReport($name, array $options = [])
    {
        $report = $this->getReport($name);
        $queryBuilder = $this->manager->createQueryBuilder();

        // Build Options
        $options = $this->buildOptions($report, $options);

        // Build the rest of the query
        $this->buildQuery($report, $queryBuilder, $options);

        return $queryBuilder->getQuery()->getResult();
    }

    protected function buildQuery(ReportInterface $report, QueryBuilder $queryBuilder, array $options)
    {
        // Build query from report
        $report->buildQuery($queryBuilder, $options);

        // Build queries from extensions
        foreach ($this->extensions as $extension) {
            $extension->buildQuery($queryBuilder, $options);
        }
    }

    protected function buildOptions(ReportInterface $report, array $options)
    {
        $resolver = new OptionsResolver();
        $report->setDefaultOptions($resolver);

        // Build Extension Options
        foreach ($this->extensions as $extension) {
            $extension->setDefaultOptions($resolver);
        }

        // Set up some global defaults
        $resolver->setRequired([
            'model',
        ]);

        $options = $resolver->resolve($options);

        if (!isset($this->models[$options['model']])) {
            throw new \InvalidArgumentException(sprintf('Model "%s" does not exist', $options['model']));
        }

        // Set model class name
        $options['visitClass'] = $this->visitClass;
        $options['class'] = $this->models[$options['model']];

        return $options;
    }

    /**
     * @param string $name
     *
     * @return ReportInterface
     */
    protected function getReport($name)
    {
        if (!array_key_exists($name, $this->reports)) {
            throw new InvalidReportException(sprintf('Could not find report "%s".', $name));
        }

        return $this->reports[$name];
    }
}
