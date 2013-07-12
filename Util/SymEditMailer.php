<?php

namespace Isometriks\Bundle\SymEditBundle\Util;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Mailer\TwigSwiftMailer;
use Isometriks\Bundle\SettingsBundle\Model\Settings;

class SymEditMailer extends TwigSwiftMailer
{
    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $router, \Twig_Environment $twig, array $parameters, Settings $settings)
    {
        parent::__construct($mailer, $router, $twig, $parameters);
        
        $this->settings = $settings;
    }
    
    /**
     * Override so we can send in our settings to emails, doesn't work when
     * you simply render a block.
     * 
     * @param type $templateName
     * @param array $context
     * @param type $fromEmail
     * @param type $toEmail
     */
    protected function sendMessage($templateName, $context, $fromEmail, $toEmail)
    {
        $context['Settings'] = $this->settings;
        
        parent::sendMessage($templateName, $context, $fromEmail, $toEmail);
    }
}