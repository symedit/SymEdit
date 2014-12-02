<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use SymEdit\Bundle\CoreBundle\Iterator\RecursivePageIterator;

class PageRepository extends EntityRepository
{
    public function findRoot()
    {
        return $this->findOneBy(array(
            'root' => true,
        ));
    }

    public function getIterator($display = true)
    {
        return new RecursivePageIterator($this->findRoot(), $display);
    }

    public function getRecursiveIterator($display = true)
    {
        return new \RecursiveIteratorIterator($this->getIterator($display), \RecursiveIteratorIterator::SELF_FIRST);
    }

    /**
     * Get pages that are actually routes, this means pages that aren't
     * the root node, or page controllers
     */
    public function findCMSPages($display = null, array $orderBy = array())
    {
        $criteria = array(
            'root' => false,
            'pageController' => false,
        );

        if ($display !== null) {
            $criteria['display'] = $display;
        }

        return $this->findBy($criteria, $orderBy);
    }

    public function findPageControllers()
    {
        return $this->findBy(array(
            'pageController' => true,
        ));
    }

    public function getPath($path)
    {
        return $this->findOneByPath($path);
    }

    public function getLastUpdated()
    {
        $result = $this->createQueryBuilder('o')
                    ->select('o.updatedAt')
                    ->orderBy('o.updatedAt', 'DESC')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getSingleResult();

        return current($result);
    }
}
