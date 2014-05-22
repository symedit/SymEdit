<?php

namespace SymEdit\Bundle\ShortcodeBundle\Model;

class ShortcodeSettings implements ShortcodeSettingsInterface
{
    protected $settings = array();

    public function __construct(array $settings = array())
    {
        $this->setSettings($settings);
    }

    public function setSettings(array $settings = array())
    {
        $this->settings = array_replace_recursive($this->settings, $settings);
    }

    public function get($name)
    {
        return $this->getSettingLocation($name);
    }

    public function has($name)
    {
        try {
            $this->getSettingLocation($name);

            return true;
        } catch (\InvalidArgumentException $ex) {
            return false;
        }
    }

    protected function getSettingLocation($name)
    {
        $parts = explode('.', $name);
        $location = &$this->settings;

        foreach ($parts as $part) {
            if (!array_key_exists($part, $location)) {
                throw new \InvalidArgumentException(sprintf('Could not find "%s"', $name));
            }

            $location = &$location[$part];
        }

        return $location;
    }
}