<?php

namespace SymEdit\Bundle\CoreBundle\Mailer\Message;

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use SymEdit\Bundle\CoreBundle\Mailer\Message\MessageInterface;
use SymEdit\Bundle\CoreBundle\Mailer\MessageBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractMessage implements MessageInterface
{
    public function buildMessage(MessageBuilderInterface $message, array $options)
    {
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
    }

    public function getParent()
    {
        return 'message';
    }
}
