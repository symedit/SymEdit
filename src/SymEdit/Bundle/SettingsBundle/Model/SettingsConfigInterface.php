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

interface SettingsConfigInterface
{
    /**
     * Get default values for all settings
     *
     * @return array Array of groups containing array of defaults
     */
    public function getDefaultValues();

    /**
     * Get raw config from config component result
     *
     * @return array Config component result
     */
    public function getConfig();
}
