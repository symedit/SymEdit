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

use SymEdit\Bundle\MailChimpBundle\Form\Type\SubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ZfrMailChimp\Exception\ExceptionInterface;
use ZfrMailChimp\Exception\Ls\AlreadySubscribedException;
use ZfrMailChimp\Exception\Ls\DoesNotExistException;

class SubscribeController extends Controller
{
    public function subscribeAction(Request $request)
    {
        $form = $this->getForm();
        $error = 'form';

        if ($form->handleRequest($request)->isValid()) {
            // Form Data
            $data = $form->getData();

            // Get Client
            $mailchimp = $this->get('symedit_mailchimp.client');

            // Attempt to subscribe the user
            try {
                $mailchimp->subscribe([
                    'id' => $data['list'],
                    'email' => [
                        'email' => $data['email'],
                    ],
                ]);

                $error = false;
            } catch (AlreadySubscribedException $e) {
                $error = 'already_subscribed';
            } catch (DoesNotExistException $e) {
                $error = 'does_not_exist';
            } catch (ExceptionInterface $e) {
                $error = 'other';
            }
        }

        return $this->render('@SymEdit/MailChimp/subscribe.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    protected function getForm()
    {
        return $this->createForm(new SubscribeType());
    }
}
