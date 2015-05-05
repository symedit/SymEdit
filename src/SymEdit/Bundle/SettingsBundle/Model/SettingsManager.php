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

use SymEdit\Bundle\SettingsBundle\Storage\SettingStorageInterface;

class SettingsManager
{
    protected $storage;
    protected $cache;

    public function __construct(SettingStorageInterface $storage, \Doctrine\Common\Cache\Cache $cache)
    {
        $this->storage = $storage;
        $this->cache = $cache;
    }

    public function save(SettingsInterface $settings)
    {
        $this->storage->save($settings);
        $this->cache->delete('settings');
    }
}
