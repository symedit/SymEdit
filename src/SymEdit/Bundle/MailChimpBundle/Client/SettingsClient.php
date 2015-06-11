<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Client;

use SymEdit\Bundle\SettingsBundle\Model\SettingsInterface;
use ZfrMailChimp\Client\MailChimpClient;

class SettingsClient extends MailChimpClient
{
    public function __construct(SettingsInterface $settings, $version = self::LATEST_API_VERSION)
    {
        if (!$settings->has('mailchimp.api_key')) {
            throw new \Exception('Mailchimp API Key not specified');
        }

        parent::__construct($settings->get('mailchimp.api_key'), $version);

        $this->getEventDispatcher()->addSubscriber(new Listener\ConnectionErrorListener());
    }
}
