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

use SymEdit\Bundle\SettingsBundle\Model\SettingsInterface;

interface SymEditMailerInterface
{
    public function setSettings(SettingsInterface $settings);

    public function setEmailSender($fromEmail);

    public function sendAdmin($templateName, $context, array $options = array());

    public function send($toEmail, $templateName, $context, array $options = array());
}
