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
use Symfony\Component\PropertyAccess\PropertyAccess;

class Tracker
{
    protected $manager;
    protected $repository;
    protected $visitClass;
    protected $propertyAccess;
    protected $trackedVisits = array();

    public function __construct(ObjectManager $manager, $class)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository($class);
        $this->visitClass = $class;
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    protected function getIdentifier($class)
    {
        return $this->manager->getClassMetadata($class)->getSingleIdentifierFieldName();
    }

    public function track($object)
    {
        $class = get_class($object);
        $identifier = $this->getIdentifier($class);
        $identifierValue = $this->propertyAccess->getValue($object, $identifier);

        if ($identifierValue === null) {
            return;
        }

        $visit = new $this->visitClass;
        $visit->setClass(get_class($object));
        $visit->setIdentifier($identifierValue);

        $this->trackedVisits[] = $visit;
    }

    public function flush()
    {
        // Skip if empty
        if (count($this->trackedVisits) === 0) {
            return;
        }

        foreach ($this->trackedVisits as $object) {
            $this->manager->persist($object);
        }

        // Flush Entities
        $this->manager->flush($this->trackedVisits);

        // Reset
        $this->trackedVisits = array();
    }
}
