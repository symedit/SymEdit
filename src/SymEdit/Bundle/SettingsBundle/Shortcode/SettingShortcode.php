<?php

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
            return 'Cannot find ' . $settingName;
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
