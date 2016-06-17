<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use SymEdit\Bundle\BlogBundle\Model\CategoryInterface;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;
use SymEdit\Bundle\BlogBundle\Repository\PostRepositoryInterface;

class PostRepository extends EntityRepository implements PostRepositoryInterface
{
    public function findPublished()
    {
        return $this->getPublishedQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    protected function findByCategoryQueryBuilder(CategoryInterface $category)
    {
        return $this->getPublishedQueryBuilder()
            ->andwhere(':category MEMBER OF o.categories')
            ->setParameter('category', $category)
        ;
    }

    public function getCategoryPaginator(CategoryInterface $category)
    {
        return $this->getPaginator(
            $this->findByCategoryQueryBuilder($category)
        );
    }

    public function findByCategory(CategoryInterface $category)
    {
        return $this->findByCategoryQueryBuilder($category)->getQuery()->getResult();
    }

    public function getRecent($max = 3)
    {
        return $this->getPublishedQueryBuilder()
            ->setMaxResults($max)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Get just the most recent post.
     */
    public function getLatestPost()
    {
        $recent = $this->getRecent(1);

        if (is_array($recent)) {
            $recent = array_pop($recent);
        }

        return $recent;
    }

    public function getCreatedAtPaginator()
    {
        return $this->getPaginator(
            $this->getCreatedAtQueryBuilder()
        );
    }

    public function getPublishedPaginator()
    {
        return $this->getPaginator(
            $this->getPublishedQueryBuilder()
        );
    }

    public function getPublishedQueryBuilder()
    {
        return $this->getQueryBuilder('o')
            ->where('o.status = :published')
            ->orWhere('o.status = :scheduled AND o.publishedAt <= :now')
            ->setParameters([
                'published' => PostInterface::PUBLISHED,
                'scheduled' => PostInterface::SCHEDULED,
                'now' => new \DateTime(),
            ])
        ;
    }

    /**
     * @return QueryBuilder
     */
    protected function getCreatedAtQueryBuilder()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.createdAt', 'DESC')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.publishedAt', 'DESC')
        ;
    }

    public function getCollectionQueryBuilder()
    {
        return $this->getQueryBuilder();
    }
}
