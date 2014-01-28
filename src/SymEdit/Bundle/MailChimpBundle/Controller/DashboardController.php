<?php

namespace SymEdit\Bundle\MailChimpBundle\Controller;

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends ResourceController
{
    public function indexAction(Request $request)
    {
        $config = $this->getConfiguration();
        $client = $this->get('symedit_mailchimp.client');

        //print_r($client->getLists()); die();

        return $this->render($config->getTemplate('index'), array(
            'lists' => $client->getLists(),
        ));
    }
}