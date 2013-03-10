<?php

namespace Isometriks\Bundle\SymEditBundle\Util;

use Isometriks\Bundle\SettingsBundle\Model\Settings;

/**
 * TODO: Probbaly just take in an array instead of a Settings object..
 * it does implement array access so we can remove this coupling, no?
 */
class Mailer
{
    private $settings;
    private $templating;
    private $mailer;

    public function __construct(Settings $settings, $templating, \Swift_Mailer $mailer, $username)
    {
        $this->username = $username;
        $this->settings = $settings;
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    /**
     * Shortcut to using Swift_Mailer with a templated body 
     * 
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $template
     * @param array $params
     */
    public function send($subject, $from, $to, $template, array $params = array())
    {
        $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($this->templating->render($template, $params));

        $this->mailer->send($message);
    }

    public function sendAdmin($subject, $template, array $params = array())
    {
        if ($this->settings->has('company.email')) {
            $contact = $this->settings->get('company.email');
            $this->send($subject, $this->username, $contact, $template, $params);
        } else {
            throw new \Exception('Setting "company.email" not defined, not sure where to send email.');
        }
    }
}