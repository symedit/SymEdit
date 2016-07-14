<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Analytics;

use Doctrine\Common\Persistence\ObjectManager;

class Recorder
{
    protected $manager;
    protected $visitClass;
    protected $models;
    protected $visits = [];

    public function __construct(ObjectManager $manager, $class, array $models)
    {
        $this->manager = $manager;
        $this->visitClass = $class;
        $this->models = $models;
    }

    public function record($model, $identifier)
    {
        if (!isset($this->models[$model])) {
            return;
        }

        $visit = new $this->visitClass();
        $visit->setModel($model);
        $visit->setIdentifier($identifier);

        $this->visits[] = $visit;
    }

    public function flush()
    {
        if (count($this->visits) === 0) {
            return;
        }

        foreach ($this->visits as $visit) {
            $this->manager->persist($visit);
        }

        // Flush
        $this->manager->flush($this->visits);

        // Clear flushed
        $this->visits = [];
    }
}
