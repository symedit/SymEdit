<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Test\Mailer;

use SymEdit\Bundle\CoreBundle\Mailer\MailerInterface;

class Mailer implements MailerInterface
{
    private static $sentMessages;

    public function send($message, array $options = array())
    {
        self::$sentMessages[] = [
            'type' => $message,
            'options' => $options,
        ];
    }

    public function getSentMessages()
    {
        return self::$sentMessages;
    }

    public function removeMessages()
    {
        self::$sentMessages = [];
    }
}
