<?php

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

use SymEdit\Bundle\ShortcodeBundle\Model\ShortcodeSettingsInterface;

interface ShortcodeInterface
{
    /**
     * Get the name aka [name {expression here}]
     */
    public function getName();

    /**
     * Returns a string with the result in it. This could use twig
     * or just return a string
     */
    public function renderShortcode($match, array $attr, $content);

    public function setSettings(ShortcodeSettingsInterface $settings);

    /**
     * @return ShortcodeSettingsInterface
     */
    public function getSettings();

    public function getSetting($setting, $default = null);
}