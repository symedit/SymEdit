<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Mailer;

use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserInterface;
use SymEdit\Bundle\CoreBundle\Mailer\MailerInterface as SymEditMailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserMailer implements MailerInterface
{
    private $mailer;
    private $router;

    public function __construct(SymEditMailerInterface $mailer, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $this->mailer->send('fos_user', [
            'user' => $user,
            'confirmationUrl' => $this->getRoute('fos_user_registration_confirm', $user),
            'template' => '@SymEdit/Email/confirm.html.twig',
            'to' => $user->getEmail(),
        ]);
    }

    public function sendResettingEmailMessage(UserInterface $user)
    {
        $this->mailer->send('fos_user', [
            'user' => $user,
            'confirmationUrl' => $this->getRoute('fos_user_resetting_reset', $user),
            'template' => '@SymEdit/Email/resetting.html.twig',
            'to' => $user->getEmail(),
        ]);
    }

    private function getRoute($routeName, UserInterface $user)
    {
        return $this->router->generate($routeName, ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
