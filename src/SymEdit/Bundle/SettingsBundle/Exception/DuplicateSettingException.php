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

class DuplicateSettingException extends \Exception
{
    public function __construct($groupName, $settingName)
    {
        parent::__construct(sprintf('Duplicate setting definition "%s.%s"', $groupName, $settingName));
    }
}
