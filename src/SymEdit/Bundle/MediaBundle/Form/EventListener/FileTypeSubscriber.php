<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;

class FileTypeSubscriber implements EventSubscriberInterface
{
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA  => 'preSetData',
            FormEvents::POST_SUBMIT   => 'postSubmit',
            FormEvents::SUBMIT        => 'submit',
        );
    }

    public function submit(FormEvent $event)
    {
        $form = $event->getForm();

        if (!$this->options['allow_remove'] || !$form->has('remove')) {
            return;
        }

        if ($form->get('remove')->getData()) {
            $event->setData(null);
        }
    }

    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (!$data instanceof MediaInterface) {
            return;
        }

        if (($callback = $this->options['callback']) !== null) {
            $data->setNameCallback($callback);
        }

        if (!$this->options['required'] && !$data->hasFile()) {
            $event->setData(null);

            return;
        }
    }

    public function preSetData(FormEvent $event)
    {
        $data   = $event->getData();
        $form   = $event->getForm();

        $form->add('file', 'file', array(
            'required' => $data === null && $this->options['required'],
            'label' => $this->options['file_label'],
            'help_block' => $this->options['file_help'],
        ));

        $require_name = $form->getConfig()->getOption('require_name');

        // If name is not set, then add the field
        if (($data === null || $data->getName() === null) && $require_name) {
            $form->add('name', 'text', array(
                'label' => $this->options['name_label'],
                'help_block' => $this->options['name_help'],
            ));
        }

        // If allow remove, add the checkbox
        if ($data !== null && $data->hasFile() && $this->options['allow_remove']) {
            $form->add('remove', 'checkbox', array(
                'mapped' => false,
                'required' => false,
                'label' => 'Remove Media',
            ));
        }
    }
}
