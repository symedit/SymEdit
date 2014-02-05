<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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