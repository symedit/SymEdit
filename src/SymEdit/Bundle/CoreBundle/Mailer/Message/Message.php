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
use Symfony\Component\OptionsResolver\OptionsResolver;

class Message extends AbstractMessage
{
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

        $resolver->setAllowedTypes('attachments', 'array');
    }

    public function getParent()
    {
        return null;
    }
}
