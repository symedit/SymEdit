<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Model;

interface SettingsInterface extends \ArrayAccess
{
    /**
     * Check if setting exists
     *
     * @param string $setting
     *
     * @return boolean
     */
    public function has($setting);

    /**
     * Get a setting
     *
     * @param string $setting
     */
    public function get($setting);

    /**
     * Get a setting, if it doesn't exist return the default provided
     *
     * @param string $setting
     * @param mixed $default
     *
     * @return mixed
     */
    public function getDefault($setting, $default = null);

    /**
     * Gets an array of all settings
     *
     * @return array Array of all settings
     */
    public function all();
}
