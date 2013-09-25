<?php

namespace Isometriks\Bundle\SymEditBundle\Form\EventListener;

use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class PageTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if ($data === null || !$data instanceof PageInterface) {
            return;
        }

        if ($data->getHomepage()) {
            $basicForm = $form->get('basic');
            $basicForm->remove('name');
            $basicForm->remove('parent');
        }
    }
}
