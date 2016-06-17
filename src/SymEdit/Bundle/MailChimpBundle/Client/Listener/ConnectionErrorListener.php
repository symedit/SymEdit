<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Client\Listener;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * This needs to run before the other error listener since the other one
 * assumes your API key is correct. We can't really make that assumption
 * with users so we check to see if there's no response (aka it couldn't connect).
 */
class ConnectionErrorListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return ['request.exception' => [
            ['handleError', 5],
        ]];
    }

    public function handleError(Event $event)
    {
        if ($event['response'] === null) {
            throw $event['exception'];
        }
    }
}
