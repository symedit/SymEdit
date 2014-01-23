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

use Symfony\Component\HttpFoundation\Request;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;

class ContactController extends Controller
{
    public function indexAction(Request $request, PageInterface $_page)
    {
        $form = $this->createForm('symedit_contact');

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();

                /**
                 * Set replyTo if it was sent so it's easier for people
                 * to email back.
                 */
                $options = empty($data['email']) ? array() : array(
                    'replyTo' => $data['email'],
                );

                $this->getMailer()->sendAdmin('@SymEdit/Contact/contact.html.twig', array(
                    'Form' => $data,
                ), $options);

                return $this->redirect($this->generateUrl('contact_success'));
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
