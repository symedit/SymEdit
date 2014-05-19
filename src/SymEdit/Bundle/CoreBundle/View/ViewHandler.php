<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\View;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler as BaseViewHandler;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\SubjectEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class ViewHandler extends BaseViewHandler
{
    protected $eventDispatcher;

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(View $view, Request $request = null)
    {
        $data = $view->getData();

        $event = new SubjectEvent($data);
        $this->eventDispatcher->dispatch(Events::SUBJECT_SET, $event);

        return parent::handle($view, $request);
    }
}
