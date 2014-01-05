<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Isometriks\Bundle\SymEditBundle\Model\CategoryInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        return $this->getRecentQuery()->getResult();
    }

    public function findPopular($max = null)
    {
        $qb = $this->getPopularQueryBuilder();

        if ($max !== null) {
            $qb->setMaxResults($max);
        }

        return $qb->getQuery()->getResult();
    }

    public function findByCategoryQueryBuilder(CategoryInterface $category)
    {
        return $this->getQueryBuilder()
                  ->where(':category MEMBER OF o.categories')
                  ->setParameter('category', $category);
    }

    public function findByCategory(CategoryInterface $category)
    {
        return $this->findByCategoryQueryBuilder($category)->getQuery()->getResult();
    }

    public function getPopularQueryBuilder()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.views', 'desc');
    }

    public function getRecentQuery()
    {
        return $this->getQueryBuilder()->getQuery();
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

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return parent::getQueryBuilder()
                   ->orderBy(sprintf('%s.createdAt', $this->getAlias()), 'DESC');
    }
}