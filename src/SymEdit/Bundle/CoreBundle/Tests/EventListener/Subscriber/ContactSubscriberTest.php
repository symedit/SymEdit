<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\EventListener\Subscriber;

use SymEdit\Bundle\CoreBundle\Event\FormEvent;
use SymEdit\Bundle\CoreBundle\EventListener\Subscriber\ContactSubscriber;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;

class ContactSubscriberTest extends TestCase
{
    public function testEmailSend()
    {
        $mailer = $this->getMock('SymEdit\Bundle\CoreBundle\Util\SymEditMailerInterface');
        $mailer->expects($this->once())
               ->method('sendAdmin')
               ->with(
                   $this->equalTo('@SymEdit/Contact/contact.html.twig'),
                   $this->equalTo(array(
                       'Form' => array(
                           'email' => 'foo@bar.com',
                       ),
                   )));

        $subscriber = new ContactSubscriber($mailer);
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');

        $form = $this->getMock('Symfony\Component\Form\FormInterface');
        $form->method('getData')
             ->will($this->returnValue(array(
                 'email' => 'foo@bar.com',
             )));

        $event = new FormEvent($form, $request);

        $subscriber->sendAdminEmail($event);
    }
}
