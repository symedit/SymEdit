<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Exception;

class InvalidSettingException extends SettingException
{
    public function __construct($setting)
    {
        parent::__construct(sprintf('Setting or group with path "%s" does not exist', $setting));
    }
}
