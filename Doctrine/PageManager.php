<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\PageManager as BaseManager;

class PageManager extends BaseManager
{
    protected $objectManager;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        parent::__construct($class);

        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
    }

    public function deletePage(PageInterface $page)
    {
        $this->objectManager->refresh($page);
        $this->objectManager->flush();
    }

    public function updatePage(PageInterface $page, $andFlush = true)
    {
        $this->objectManager->persist($page);

        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    public function findPageBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findPagesBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findRoot()
    {
        return $this->repository->findRoot();
    }
}