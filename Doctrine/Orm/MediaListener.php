<?php

namespace Isometriks\Bundle\MediaBundle\Doctrine\Orm;

use Isometriks\Bundle\MediaBundle\Doctrine\AbstractMediaListener;
use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;

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
}