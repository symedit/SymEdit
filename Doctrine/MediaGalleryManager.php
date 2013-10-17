<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Isometriks\Bundle\MediaBundle\Model\MediaGalleryInterface;
use Isometriks\Bundle\MediaBundle\Model\MediaGalleryManager as BaseMediaGalleryManager;

class MediaGalleryManager extends BaseMediaGalleryManager
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

    public function findGalleryBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }    
    
    public function deleteGallery(MediaGalleryInterface $gallery)
    {
        $this->om->remove($gallery);
        $this->om->flush();
    }

    public function updateGallery(MediaGalleryInterface $gallery, $andFlush = true)
    {
        $this->om->persist($gallery);
        
        if ($andFlush) {
            $this->om->flush($gallery);
        }
    }
}