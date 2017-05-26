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

use SymEdit\Bundle\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMessage extends AbstractMessage
{
    private $settings;

    public function __construct(SettingsManager $settings)
    {
        $this->settings = $settings;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $companySettings = $this->settings->load('company');
        $companyName = $companySettings->get('name');
        $companyEmail = $companySettings->get('email');

        // Set company name and email as from address
        $resolver->setDefaults([
            'to' => [$companyEmail => $companyName],
        ]);
    }
}
