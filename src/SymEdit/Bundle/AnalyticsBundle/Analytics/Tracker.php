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
use Sylius\Component\Resource\Factory\FactoryInterface;
use SymEdit\Bundle\AnalyticsBundle\Model\VisitInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Tracker
{
    protected $manager;
    protected $visitFactory;
    protected $models;
    protected $modelsByClass;
    protected $propertyAccessor;
    protected $trackedVisits = [];

    public function __construct(ObjectManager $manager, FactoryInterface $visitFactory, array $models)
    {
        $this->manager = $manager;
        $this->visitFactory = $visitFactory;
        $this->models = $models;
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
        // Make sure it's an object.
        if (!is_object($object)) {
            return;
        }

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

        $identifierValue = $this->getPropertyAccessor()->getValue($object, $identifier);

        if ($identifierValue === null) {
            return;
        }

        $visit = $this->visitFactory->createNew();
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

    protected function getPropertyAccessor()
    {
        if ($this->propertyAccessor === null) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }

    /**
     * @return VisitInterface[]
     */
    public function getTrackedVisits()
    {
        return $this->trackedVisits;
    }
}
