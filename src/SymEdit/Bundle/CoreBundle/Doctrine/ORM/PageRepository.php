<?php

namespace SymEdit\Bundle\CoreBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    public function findRoot()
    {
        return $this->findOneBy(array(
            'root' => true,
        ));
    }

    /**
     * Get pages that are actually routes, this means pages that aren't
     * the root node, or page controllers
     */
    public function findCMSPages($display = null)
    {
        $criteria = array(
            'root' => false,
            'pageController' => false,
        );

        if ($display !== null) {
           $criteria['display'] = $display;
        }

        return $this->findBy($criteria);
    }

    public function findPageControllers()
    {
        return $this->findBy(array(
            'pageController' => true
        ));
    }

    public function getPath($path)
    {
        return $this->findOneByPath($path);
    }

    public function findPopular($max = null)
    {
        $qb = $this->getPopularQueryBuilder();

        if ($max !== null) {
            $qb->setMaxResults($max);
        }

        return $qb->getQuery()->getResult();
    }

    public function getPopularQueryBuilder()
    {
        return $this->createQueryBuilder('p')
                    ->where('p.root = false')
                    ->andWhere('p.pageController = false')
                    ->andWhere('p.display = true')
                    ->orderBy('p.views', 'desc');
    }
}