<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $basic = $form->get('basic');

        $basic->add('plainPassword', 'repeated', [
            'required' => ($data === null || $data->getId() === null),
            'type' => 'password',
            'options' => ['translation_domain' => 'FOSUserBundle'],
            'first_options' => ['label' => 'form.password'],
            'second_options' => ['label' => 'form.password_confirmation'],
            'invalid_message' => 'fos_user.password.mismatch',
        ]);
    }
}
