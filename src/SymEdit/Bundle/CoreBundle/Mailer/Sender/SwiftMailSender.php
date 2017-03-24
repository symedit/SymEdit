<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Mailer\Sender;

use SymEdit\Bundle\CoreBundle\Mailer\MessageBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SwiftMailSender implements MailSenderInterface
{
    private $swiftMailer;

    public function __construct(\Swift_Mailer $swiftMailer)
    {
        $this->swiftMailer = $swiftMailer;
    }

    public function send(MessageBuilderInterface $message)
    {
        $swiftMessage = \Swift_Message::newInstance()
            ->setSubject($message->getSubject())
            ->setFrom($message->getFrom())
            ->setTo($message->getTo())
            ->setReplyTo($message->getReplyTo())
        ;

        // Set Content
        foreach ($message->getContent() as $contentType => $content) {
            $swiftMessage->setBody($content, $contentType);
        }

        // Attach any files
        $this->attachFiles($swiftMessage, $message->getAttachments());

        // Send
        $this->swiftMailer->send($swiftMessage);
    }

    private function attachFiles(\Swift_Message $message, array $files)
    {
        foreach ($files as $file) {
            $attachment = \Swift_Attachment::fromPath($file);

            if ($file instanceof UploadedFile) {
                $attachment->setFilename($file->getClientOriginalName());
            }

            $message->attach($attachment);
        }
    }
}
