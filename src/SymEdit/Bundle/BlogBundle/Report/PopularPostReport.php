<?php

namespace SymEdit\Bundle\BlogBundle\Report;

use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\AnalyticsBundle\Report\PopularReport;
use SymEdit\Bundle\BlogBundle\Model\Post;

class PopularPostReport extends PopularReport
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildQuery(ObjectManager $manager, $visitClass, $options = array())
    {
        $qb = parent::buildQuery($manager, $visitClass, $options);

        if ($this->getOption($options, 'published', true)) {
            $qb
                ->andWhere('c.status = :status')
                ->setParameter('status', Post::PUBLISHED);
        }

        return $qb;
    }

    public function getClass(array $options = array())
    {
        return $this->class;
    }

    public function getName()
    {
        return 'popular_posts';
    }
}