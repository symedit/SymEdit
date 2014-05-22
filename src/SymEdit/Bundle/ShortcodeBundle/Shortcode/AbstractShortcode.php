<?php

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

use SymEdit\Bundle\ShortcodeBundle\Model\ShortcodeSettingsInterface;

abstract class AbstractShortcode implements ShortcodeInterface
{
    protected $settings;

    public function setSettings(ShortcodeSettingsInterface $settings)
    {
        $this->settings = $settings;;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function getSetting($setting, $default = null)
    {
        $settings = $this->getSettings();

        return $settings->has($setting) ? $settings->get($setting) : $default;
    }
}