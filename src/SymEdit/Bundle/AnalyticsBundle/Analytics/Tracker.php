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
    protected $visitClass;
    protected $models;
    protected $modelsByClass;
    protected $propertyAccess;
    protected $trackedVisits = array();

    public function __construct(ObjectManager $manager, $class, array $models)
    {
        $this->manager = $manager;
        $this->visitClass = $class;
        $this->models = $models;
        $this->propertyAccess = PropertyAccess::createPropertyAccessor();
    }

    protected function getIdentifier($class)
    {
        try {
            return $this->manager->getClassMetadata($class)->getSingleIdentifierFieldName();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function track($object)
    {
        // Get class
        $className = get_class($object);

        // Check if trackable
        if (($modelName = $this->getModelName($className)) === null) {
            return;
        }

        // No identifier
        if (($identifier = $this->getIdentifier($className)) === false) {
            return;
        }

        $identifierValue = $this->propertyAccess->getValue($object, $identifier);

        if ($identifierValue === null) {
            return;
        }

        $visit = new $this->visitClass();
        $visit->setModel($modelName);
        $visit->setIdentifier($identifierValue);

        $this->trackedVisits[] = $visit;
    }

    protected function getModelName($className)
    {
        if ($this->modelsByClass === null) {
            $this->modelsByClass = array_flip($this->models);
        }

        return isset($this->modelsByClass[$className]) ? $this->modelsByClass[$className] : null;
    }

    public function getTrackedVisits()
    {
        return $this->trackedVisits;
    }
}
