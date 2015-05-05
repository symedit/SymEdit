<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Storage;

use SymEdit\Bundle\SettingsBundle\Model\SettingsInterface;

interface SettingStorageInterface
{
    /**
     * @return array Array of groups and settings
     */
    public function load();

    /**
     * Save settings
     *
     * @param array $settings
     */
    public function save(SettingsInterface $settings);
}
