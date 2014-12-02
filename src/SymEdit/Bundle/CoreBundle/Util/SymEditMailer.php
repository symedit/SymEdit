<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Util;

use FOS\UserBundle\Mailer\TwigSwiftMailer;
use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SymEditMailer extends TwigSwiftMailer implements SymEditMailerInterface
{
    protected $settings;
    protected $fromEmail;

    public function setSettings(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function setEmailSender($fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function sendAdmin($templateName, $context, array $options = array())
    {
        $toEmail = $this->settings['company']['email'];

        $this->sendMessage($templateName, $context, null, $toEmail, $options);
    }

    public function send($toEmail, $templateName, $context, array $options = array())
    {
        $this->sendMessage($templateName, $context, null, $toEmail, $options);
    }

    /**
     * @param string $templateName
     * @param array  $context
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $toEmail, array $options = array())
    {
        /**
         * Overwrite the fromEmail, you COULD change this with $options though..
         */
        $fromEmail = array(
            $this->fromEmail => $this->settings->get('company.name'),
        );

        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail);

        /**
         * Add extra options
         */
        foreach ($options as $key => $value) {
            // Attach the files and continue to next option
            if ($key === 'attachments') {
                $this->attachFiles($message, $value);

                continue;
            }

            $method = 'set'.ucfirst($key);

            if (!method_exists($message, $method)) {
                throw new \InvalidArgumentException(sprintf('There is no method called "%s".', $method));
            }

            $message->$method($value);
        }

        if (!empty($htmlBody)) {
            $message
                ->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain')
            ;
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }

    protected function attachFiles(\Swift_Message $message, $files)
    {
        $files = is_array($files) ? $files : array($files);

        foreach ($files as $file) {
            $attachment = \Swift_Attachment::fromPath($file);

            if ($file instanceof UploadedFile) {
                $attachment->setFilename($file->getClientOriginalName());
            }

            $message->attach($attachment);
        }
    }
}
