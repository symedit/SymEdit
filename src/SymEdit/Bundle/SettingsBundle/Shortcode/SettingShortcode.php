<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Shortcode;

use SymEdit\Bundle\SettingsBundle\Model\Settings;
use SymEdit\Bundle\ShortcodeBundle\Shortcode\AbstractShortcode;

class SettingShortcode extends AbstractShortcode
{
    protected $symeditSettings;

    public function __construct(Settings $settings)
    {
        $this->symeditSettings = $settings;
    }

    public function renderShortcode($match, array $attr, $content)
    {
        $settingName = current($attr);

        if (!$this->symeditSettings->has($settingName)) {
            return 'Cannot find '.$settingName;
        } else {
            $settingValue = $this->symeditSettings->get($settingName);
        }

        return is_string($settingValue) ? $settingValue : $match;
    }

    public function getName()
    {
        return 'setting';
    }
}
