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

        $visit = new $this->visitClass;
        $visit->setClass(get_class($object));
        $visit->setIdentifier($this->propertyAccess->getValue($object, $identifier));

        $this->manager->persist($visit);
        $this->manager->flush($visit);
    }
}