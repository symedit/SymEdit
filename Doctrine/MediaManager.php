<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Isometriks\Bundle\MediaBundle\Model\MediaManager as BaseMediaManager;

class MediaManager extends BaseMediaManager
{
    protected $om;
    protected $repository;

    public function __construct($class, ObjectManager $om)
    {
        parent::__construct($class);
        
        $this->om = $om;
        $this->repository = $om->getRepository($class);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }
    
    public function findAll()
    {
        return $this->repository->findAll();
    }    

    public function findMediaBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }    
    
    public function deleteMedia(MediaInterface $media)
    {
        $this->om->remove($media);
        $this->om->flush();
    }

    public function updateMedia(MediaInterface $media, $andFlush = true)
    {
        $this->om->persist($media);
        
        if ($andFlush) {
            $this->om->flush($media);
        }
    }
}