<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Mailer;

use SymEdit\Bundle\CoreBundle\Mailer\Extension\MailerExtensionInterface;
use SymEdit\Bundle\CoreBundle\Mailer\Message\MessageInterface;
use SymEdit\Bundle\CoreBundle\Mailer\Sender\MailSenderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Mailer implements MailerInterface
{
    private $sender;
    private $messages;
    private $extensions;

    public function __construct(MailSenderInterface $sender, array $messages, array $extensions = array())
    {
        $this->sender = $sender;
        $this->messages = $messages;
        $this->extensions = $extensions;
    }

    public function send($message, array $options = array())
    {
        // Get All Options
        $resolvedOptions = $this->getDefaultOptions($message, $options);

        // Build Message
        $messageBuilder = $this->buildMessage($message, $resolvedOptions);

        // Send Message
        $this->sender->send($messageBuilder);
    }

    private function getDefaultOptions($message, array $options)
    {
        $resolver = new OptionsResolver();
        $parents = $this->getLineage($message);

        // Build all extension defaults
        array_map(function (MailerExtensionInterface $extension) use ($resolver) {
            $extension->getDefaultOptions($resolver);
        }, $this->extensions);

        // Build all default options of parents, starting with greatest
        array_map(function (MessageInterface $builder) use ($resolver) {
            $builder->getDefaultOptions($resolver);
        }, $parents);

        return $resolver->resolve($options);
    }

    /**
     * @return MessageBuilderInterface
     */
    private function buildMessage($message, array $options)
    {
        $messageBuilder = new MessageBuilder();
        $parents = $this->getLineage($message);

        // Build from extensions first this time
        array_map(function (MailerExtensionInterface $extension) use ($messageBuilder, $options) {
            $extension->buildMessage($messageBuilder, $options);
        }, $this->extensions);

        // Build from parents
        array_map(function (MessageInterface $builder) use ($messageBuilder, $options) {
            $builder->buildMessage($messageBuilder, $options);
        }, $parents);

        return $messageBuilder;
    }

    private function getLineage($message)
    {
        $currentBuilder = $this->getMessage($message);
        $stack = [$currentBuilder];

        while ($currentBuilder->getParent() !== null) {
            $currentBuilder = $this->getMessage($currentBuilder->getParent());
            $stack[] = $currentBuilder;
        }

        return array_reverse($stack);
    }

    private function getMessage($message)
    {
        if (!isset($this->messages[$message])) {
            throw new \InvalidArgumentException(sprintf('Message of type "%s" does not exist', $message));
        }

        return $this->messages[$message];
    }
}
