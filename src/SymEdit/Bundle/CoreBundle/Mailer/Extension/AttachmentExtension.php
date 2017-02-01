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

class AttachmentExtension implements MailerExtensionInterface
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

        // Render Twig template with options as context
        $content = $this->twig->render($options['template'], $options);

        // Set content
        $message->setContent($content);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('template', null);
    }
}
