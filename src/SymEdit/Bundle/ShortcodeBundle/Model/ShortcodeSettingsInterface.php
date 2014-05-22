<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ShortcodeBundle\Model;

interface ShortcodeSettingsInterface
{
    public function setSettings(array $settings = array());
    public function has($name);
    public function get($name);
}
