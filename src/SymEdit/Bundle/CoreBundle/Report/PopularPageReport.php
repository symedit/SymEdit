<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Report;

use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\AnalyticsBundle\Report\PopularReport;

class PopularPageReport extends PopularReport
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildQuery(ObjectManager $manager, $visitClass, $options = array())
    {
        return parent::buildQuery($manager, $visitClass, $options)
                ->andWhere('c.root = false');
    }

    public function getClass(array $options = array())
    {
        return $this->class;
    }

    public function getName()
    {
        return 'popular_pages';
    }
}