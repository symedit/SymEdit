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

interface MessageBuilderInterface
{
    /**
     * Set to, can be an array or string, or array of array or string
     *
     * @param array|string $to
     */
    public function setTo($to);
    public function getTo();
    public function addTo($to);

    public function setFrom($from);
    public function getFrom();

    public function setReplyTo($replyTo);
    public function getReplyTo();
    public function addReplyTo($replyTo);

    public function setContent($content, $type = 'text/html');
    public function getContent();

    public function setSubject($subject);
    public function getSubject();

    public function setAttachments($attachments);
    public function getAttachments();
    public function addAttachment($attachment);
}
