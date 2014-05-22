<?php

namespace SymEdit\Bundle\ShortcodeBundle\Model;

interface ShortcodeSettingsInterface
{
    public function setSettings(array $settings = array());
    public function has($name);
    public function get($name);
}