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
use SymEdit\Bundle\BlogBundle\Model\Post;

class PostRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        return $this->getRecentQuery()->getResult();
    }

    public function findPublished()
    {
        return $this->findBy(array(
            'status' => Post::PUBLISHED,
        ));
    }

    public function findByCategoryQueryBuilder(CategoryInterface $category)
    {
        return $this->getQueryBuilder()
                  ->where(':category MEMBER OF o.categories')
                  ->andWhere('o.status = :status')
                  ->setParameter('category', $category)
                  ->setParameter('status', Post::PUBLISHED);
    }

    public function findByCategory(CategoryInterface $category)
    {
        return $this->findByCategoryQueryBuilder($category)->getQuery()->getResult();
    }

    public function getRecentQuery()
    {
        return $this->getQueryBuilder()->getQuery();
    }

    public function getRecent($max=3)
    {
        $criteria = array(
            'status' => Post::PUBLISHED,
        );

        return $this->findBy($criteria, null, $max);
    }

    /**
     * Get just the most recent post
     */
    public function getLatestPost()
    {
        $recent = $this->getRecent(1);

        if (is_array($recent)) {
            $recent = array_pop($recent);
        }

        return $recent;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return parent::getQueryBuilder()
                   ->orderBy(sprintf('%s.createdAt', $this->getAlias()), 'DESC');
    }

    public function getCollectionQueryBuilder()
    {
        return $this->getQueryBuilder();
    }
}