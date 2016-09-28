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
        $mailer = $this->getMockBuilder('SymEdit\Bundle\CoreBundle\Util\SymEditMailerInterface')
            ->getMock()
        ;

        $mailer
            ->expects($this->once())
            ->method('sendAdmin')
            ->with(
                $this->equalTo('@SymEdit/Contact/contact.html.twig'),
                $this->equalTo([
                    'Form' => [
                        'email' => 'foo@bar.com',
                    ],
                ]
            ))
        ;

        $subscriber = new ContactSubscriber($mailer);
        $request = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->getMock()
        ;

        $form = $this->getMockBuilder('Symfony\Component\Form\FormInterface')
            ->getMock()
        ;

        $form
            ->method('getData')
            ->will($this->returnValue([
                'email' => 'foo@bar.com',
            ]))
        ;

        $event = new FormEvent($form, $request);

        $subscriber->sendAdminEmail($event);
    }
}
