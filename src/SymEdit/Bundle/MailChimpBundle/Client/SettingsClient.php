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

use Sylius\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use SymEdit\Bundle\MailChimpBundle\Client\Listener\ConnectionErrorListener;
use ZfrMailChimp\Client\MailChimpClient;

class SettingsClient extends MailChimpClient
{
    public function __construct(SettingsManagerInterface $settings, $version = self::LATEST_API_VERSION)
    {
        $mailchimp = $settings->loadSettings('mailchimp');

        parent::__construct($mailchimp->get('api_key'), $version);

        $this->getEventDispatcher()->addSubscriber(new ConnectionErrorListener());
    }
}
