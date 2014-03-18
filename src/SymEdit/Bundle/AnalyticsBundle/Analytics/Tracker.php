<?php

namespace SymEdit\Bundle\AnalyticsBundle\Analytics;

use Doctrine\Common\Persistence\ObjectManager;

class Tracker
{
    protected $manager;
    protected $repository;
    protected $visitClass;

    public function __construct(ObjectManager $manager, $class)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository($class);
        $this->visitClass = $class;
    }

    public function track($object)
    {
        $visit = new $this->visitClass;
        $visit->setClass(get_class($object));
        $visit->setIdentifier($object->getId());

        $this->manager->persist($visit);
        $this->manager->flush();
    }
}