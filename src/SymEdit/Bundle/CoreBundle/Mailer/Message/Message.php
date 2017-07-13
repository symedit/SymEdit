<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Mailer\Message;

use SymEdit\Bundle\CoreBundle\Mailer\MessageBuilderInterface;
use SymEdit\Bundle\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Message extends AbstractMessage
{
    private $settings;
    private $defaultFromAddress;

    public function __construct(SettingsManager $settings, $defaultFromAddress)
    {
        $this->settings = $settings;
        $this->defaultFromAddress = $defaultFromAddress;
    }

    public function buildMessage(MessageBuilderInterface $message, array $options)
    {
        $message->setTo($options['to']);
        $message->setFrom($options['from']);
        $message->setReplyTo($options['replyTo']);
        $message->setAttachments($options['attachments']);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'to',
            'from',
        ]);

        $resolver->setDefaults([
            'replyTo' => null,
            'subject' => 'New Message',
            'attachments' => [],
        ]);

        $companySettings = $this->settings->load('company');
        $companyName = $companySettings->get('name');

        // Set Default Email
        $resolver->setDefault('from', [
            $this->defaultFromAddress => $companyName
        ]);

        $resolver->setAllowedTypes('attachments', 'array');
    }

    public function getParent()
    {
        return null;
    }
}
