<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Doctrine\MongoDB;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;
use SymEdit\Bundle\CoreBundle\Doctrine\AbstractPagePathListener;

class PagePathListener extends AbstractPagePathListener
{
    public function getSubscribedEvents()
    {
        return array(
            Events::postPersist,
            Events::postUpdate,
        );
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRoutes($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRoutes($args);
    }
}
