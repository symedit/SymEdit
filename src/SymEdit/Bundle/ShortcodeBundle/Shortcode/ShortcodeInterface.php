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

interface ShortcodeInterface
{
    /**
     * Get the name aka [name {expression here}].
     */
    public function getName();

    /**
     * Returns a string with the result in it. This could use twig
     * or just return a string.
     */
    public function renderShortcode($match, array $attr, $content);

    public function setSettings(ShortcodeSettingsInterface $settings);

    /**
     * @return ShortcodeSettingsInterface
     */
    public function getSettings();

    public function getSetting($setting, $default = null);
}
