<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Shortcode;

use SymEdit\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use SymEdit\Bundle\ShortcodeBundle\Shortcode\AbstractShortcode;

class SettingShortcode extends AbstractShortcode
{
    protected $settingsManager;

    public function __construct(SettingsManagerInterface $settings)
    {
        $this->settingsManager = $settings;
    }

    public function renderShortcode($match, array $attr, $content)
    {
        $name = current($attr);

        // Not a specific setting
        if (false === strpos($name, '.')) {
            return $match;
        }

        list($namespace, $name) = explode('.', $name);
        $settings = $this->settingsManager->load($namespace);

        if (!$settings->has($name)) {
            return $match;
        }

        return $settings->get($name);
    }

    public function getName()
    {
        return 'setting';
    }
}
