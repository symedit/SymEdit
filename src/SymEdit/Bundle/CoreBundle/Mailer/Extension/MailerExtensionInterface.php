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

use SymEdit\Bundle\CoreBundle\Mailer\MessageBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface MailerExtensionInterface
{
    public function buildMessage(MessageBuilderInterface $message, array $options);
    public function getDefaultOptions(OptionsResolver $resolver);
}
