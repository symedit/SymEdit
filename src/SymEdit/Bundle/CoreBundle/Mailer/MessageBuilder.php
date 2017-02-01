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

class MessageBuilder implements MessageBuilderInterface
{
    private $from;
    private $to;
    private $replyTo;
    private $subject;
    private $attachments;
    private $content;

    public function __construct()
    {
        $this->from = [];
        $this->to = [];
        $this->replyTo = [];
        $this->attachments = [];
        $this->content = [];
    }

    public function setFrom($from)
    {
        $this->from = (array)$from;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = (array)$replyTo;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function addReplyTo($replyTo)
    {
        if (is_array($replyTo)) {
            $this->replyTo[key($replyTo)] = current($replyTo);
        } else {
            $this->replyTo[] = $replyTo;
        }
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setTo($to)
    {
        $this->to = (array)$to;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function addTo($to)
    {
        if (is_array($to)) {
            $this->to[key($to)] = current($to);
        } else {
            $this->to[] = $to;
        }
    }

    public function setAttachments($attachments)
    {
        $this->attachments = (array)$attachments;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function addAttachment($attachment)
    {
        $this->attachments[] = $attachment;
    }

    public function setContent($content, $type = 'text/html')
    {
        $this->content[$type] = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}
