<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Isometriks\Bundle\SymEditBundle\Model\PostInterface;
use Isometriks\Bundle\SymEditBundle\Model\PostManager as BaseManager;

class PostManager extends BaseManager
{
    protected $objectManager;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        parent::__construct($class);

        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
    }

    public function deletePost(PostInterface $post)
    {
        $this->objectManager->remove($post);
        $this->objectManager->flush();
    }

    public function updatePost(PostInterface $post, $andFlush = true)
    {
        $this->objectManager->persist($post);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAllOrdered();
    }

    public function findPostBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findPostsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findRecentPosts($max = 3)
    {
        die('not implemented yet..');
    }

    public function enableStatusFilter()
    {
        parent::enableStatusFilter();

        $this->getFilters()->enable(parent::STATUS_FILTER);
    }

    public function disableStatusFilter()
    {
        parent::disableStatusFilter();

        $this->getFilters()->disable(parent::STATUS_FILTER);
    }

    protected function getFilters()
    {
        if ($this->objectManager instanceof EntityManager) {
            return $this->objectManager->getFilters();

        } elseif ($this->objectManager instanceof DocumentManager) {
            return $this->objectManager->getFilterCollection();
        }
    }
}