<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\FormEvent;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request, PageInterface $_page)
    {
        $form = $this->createForm('symedit_contact');

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Dispatch Event
                $event = new FormEvent($form, $request);
                $this->get('event_dispatcher')->dispatch(Events::CONTACT_SUBMIT_VALID, $event);

                if ($response = $event->getResponse() === null) {
                    $url = $this->generateUrl('contact_success');
                    $response = new RedirectResponse($url);
                }

                return $response;
            }
        }

        return $this->render('@SymEdit/Contact/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function successAction()
    {
        return $this->render('@SymEdit/Contact/success.html.twig');
    }
}
