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
use SymEdit\Bundle\CoreBundle\Repository\PageRepositoryInterface;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    public function findRoot()
    {
        return $this->findOneBy([
            'root' => true,
        ]);
    }

    public function getIterator($display = true)
    {
        return new RecursivePageIterator($this->findRoot(), $display);
    }

    public function getRecursiveIterator($display = true)
    {
        return new \RecursiveIteratorIterator($this->getIterator($display), \RecursiveIteratorIterator::SELF_FIRST);
    }

    public function findPageControllers()
    {
        return $this->findBy([
            'pageController' => true,
        ]);
    }

    public function getLastUpdated()
    {
        $result = $this->createQueryBuilder('o')
            ->select('o.updatedAt')
            ->orderBy('o.updatedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;

        return current($result);
    }
}
