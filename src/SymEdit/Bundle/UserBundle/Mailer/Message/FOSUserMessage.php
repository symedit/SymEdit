<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Mailer\Message;

use SymEdit\Bundle\CoreBundle\Mailer\Message\AbstractMessage;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FOSUserMessage extends AbstractMessage
{
    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'user',
            'confirmationUrl',
        ]);
    }
}
