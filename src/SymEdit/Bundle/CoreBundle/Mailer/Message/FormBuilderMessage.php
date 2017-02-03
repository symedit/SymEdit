<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Mailer\Message;

use SymEdit\Bundle\CoreBundle\Mailer\MessageBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormBuilderMessage extends AbstractMessage
{
    public function buildMessage(MessageBuilderInterface $message, array $options)
    {
        $result = $options['result'];
        $message->setReplyTo($result->getReplyTo());
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SymEdit/Email/form-builder.html.twig',
        ]);

        $resolver->setRequired([
            'form_builder',
            'result',
        ]);
    }

    public function getParent()
    {
        return 'admin';
    }
}
