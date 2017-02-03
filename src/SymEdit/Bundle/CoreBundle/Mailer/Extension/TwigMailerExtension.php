<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Mailer\Extension;

use SymEdit\Bundle\CoreBundle\Mailer\Extension\MailerExtensionInterface;
use SymEdit\Bundle\CoreBundle\Mailer\MessageBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TwigMailerExtension implements MailerExtensionInterface
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function buildMessage(MessageBuilderInterface $message, array $options)
    {
        if ($options['template'] === null) {
            return;
        }

        $template = $this->twig->loadTemplate($options['template']);
        $subject = $template->renderBlock('subject', $options);
        $textBody = $template->renderBlock('body_text', $options);
        $htmlBody = $template->renderBlock('body_html', $options);

        $message->setSubject($subject);
        $message->setContent($textBody, 'text/plain');
        $message->setContent($htmlBody, 'text/html');
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => null,
            'templateVars' => null,
        ]);
    }
}
