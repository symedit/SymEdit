<?php

namespace SymEdit\Bundle\MailChimpBundle\Client;

use SymEdit\Bundle\SettingsBundle\Model\Settings;
use ZfrMailChimp\Client\MailChimpClient;

class SettingsClient extends MailChimpClient
{
    public function __construct(Settings $settings, $version = self::LATEST_API_VERSION)
    {
        if (!$settings->has('mailchimp.api_key')) {
            throw new \Exception('Mailchimp API Key not specified');
        }

        parent::__construct($settings->get('mailchimp.api_key'), $version);

        $this->getEventDispatcher()->addSubscriber(new Listener\ConnectionErrorListener());
    }
}