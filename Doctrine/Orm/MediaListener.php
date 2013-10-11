<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine\Orm;

use Isometriks\Bundle\MediaBundle\Doctrine\AbstractMediaListener;
use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;

class MediaListener extends AbstractMediaListener
{
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,

            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
            
            Events::onFlush,
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->preUpload($object);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->preUpload($object);
            
            /**
             * Compute changeset
             */
            $em = $args->getEntityManager();
            $uow = $em->getUnitOfWork();
            $meta = $em->getClassMetadata(get_class($object));
            $uow->recomputeSingleEntityChangeSet($meta, $object);            
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->upload($object);
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->upload($object);
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->removeUpload($object);
        }
    }
    
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() as $object) {
            if (!$object instanceof MediaInterface) {
                continue;
            }
            
            if (($callback = $object->getNameCallback()) === null) {
                continue;
            }
            
            $oldName = $object->getName();
            $object->setName($callback($object));
            
            $oldPath = $object->getPath();
            $object->setPath($this->uploadManager->getUploadPath($object));
            
            $uow->propertyChanged($object, 'name', $oldName, $object->getName());
            $uow->propertyChanged($object, 'path', $oldPath, $object->getPath());
        }
    }
}