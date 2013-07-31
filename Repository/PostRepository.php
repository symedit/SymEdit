<?php

namespace Isometriks\Bundle\SymEditBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository {

    /**
     * @return \Doctrine\ORM\Query
     */
    protected function getRecentQuery()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.createdAt', 'DESC')
                    ->getQuery();
    }

    public function getRecent($max=3)
    {
        return $this->getRecentQuery()
                ->setMaxResults($max)
                ->getResult();
    }

    /**
     * Get just the most recent post
     */
    public function getRecentPost()
    {
        return $this->getRecentQuery()
                ->setMaxResults(1)
                ->getSingleResult();
    }

}