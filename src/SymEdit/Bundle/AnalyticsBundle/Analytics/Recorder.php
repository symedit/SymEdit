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
    protected $visits = array();

    public function __construct(ObjectManager $manager, $class)
    {
        $this->manager = $manager;
        $this->visitClass = $class;
    }

    public function record($className, $identifier)
    {
        if (!$this->classExists($className)) {
            return;
        }

        $visit = new $this->visitClass;
        $visit->setClass($className);
        $visit->setIdentifier($identifier);

        $this->visits[] = $visit;
    }

    protected function classExists($className)
    {
        try {
            $this->manager->getClassMetadata($className);
        } catch (\Exception $e) {
            return false;
        }

        return true;
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
        $this->visits = array();
    }
}
