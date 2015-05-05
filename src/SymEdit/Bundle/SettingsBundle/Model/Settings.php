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

use SymEdit\Bundle\SettingsBundle\Exception\InvalidSettingException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class Settings implements SettingsInterface
{
    protected $settings;
    protected $accessor;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function has($setting)
    {
        $parts = explode('.', $setting, 2);
        $path = &$this->settings;

        foreach ($parts as $part) {
            if (!array_key_exists($part, $path)) {
                return false;
            }

            $path = &$path[$part];
        }

        return true;
    }

    public function get($setting)
    {
        if (!$this->has($setting)) {
            throw new InvalidSettingException($setting);
        }

        $path = $this->getPropertyPath($setting);
        $accessor = $this->getPropertyAccessor();

        return $accessor->getValue($this->settings, $path);
    }

    public function set($setting, $value)
    {
        if (!$this->has($setting)) {
            throw new InvalidSettingException($setting);
        }
        
        $path = $this->getPropertyPath($setting);
        $accessor = $this->getPropertyAccessor();

        return $accessor->setValue($this->settings, $path, $value);
    }

    public function getDefault($setting, $default = null)
    {
        if ($this->has($setting)) {
            return $this->get($setting);
        }

        return $default;
    }

    public function all()
    {
        return $this->settings;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {

    }

    /**
     * Changes paths from group.setting into [group][setting] for
     * property access. Or "group" => [group]
     *
     * @param string $offset
     * @return string
     */
    protected function getPropertyPath($offset)
    {
        $parts = explode('.', $offset);

        return sprintf('[%s]', implode('][', $parts));
    }

    /**
     * @return PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        if ($this->accessor === null) {
            $this->accessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->accessor;
    }
}
