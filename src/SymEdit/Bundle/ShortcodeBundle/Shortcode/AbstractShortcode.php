<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

use SymEdit\Bundle\ShortcodeBundle\Model\ShortcodeSettingsInterface;

abstract class AbstractShortcode implements ShortcodeInterface
{
    protected $settings;

    public function setSettings(ShortcodeSettingsInterface $settings)
    {
        $this->settings = $settings;
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
