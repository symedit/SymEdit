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

use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FileTypeSubscriber implements EventSubscriberInterface
{
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::POST_SUBMIT => 'postSubmit',
            FormEvents::SUBMIT => 'submit',
        ];
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
        $data = $event->getData();
        $form = $event->getForm();
        $hasFile = $data !== null && $data->hasFile();

        // Require if there is no file otherwise use the default
        $required = $hasFile ? false : $this->options['required'];

        $form->add('file', FileType::class, [
            'required' => $required,
            'label' => $this->options['file_label'],
            'help_block' => $this->options['file_help'],
        ]);

        $require_name = $form->getConfig()->getOption('require_name');
        $allow_blank_name = $form->getConfig()->getOption('allow_blank_name');

        // If name is not set, then add the field
        if (($data === null || $data->getName() === null) && $require_name) {
            $form->add('name', TextType::class, [
                'label' => $this->options['name_label'],
                'help_block' => $this->options['name_help'],
                'required' => !$allow_blank_name,
            ]);
        }

        // If allow remove, add the checkbox
        if ($hasFile && $this->options['allow_remove']) {
            $form->add('remove', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Remove Media',
            ]);
        }
    }
}
