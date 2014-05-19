<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\EventListener;

use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Searches for #group.settingName# in the attributes of the request
 * to attempt to replace them with actual setting values
 *
 * @TODO: Add a check to see if the string is ONLY the setting, in that
 *        case just replace it instead of substituting a string. That
 *        way we might be able to add objects eventually.
 */
class RequestListener
{
    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        foreach ($request->attributes as $key => $value) {
            $newValue = $this->processAttribute($value);

            $request->attributes->set($key, $newValue);
        }
    }

    protected function processAttribute($value)
    {
        if (is_string($value)) {
            return $this->replaceString($value);
        } elseif (is_array($value)) {
            foreach ($value as $key => $subValue) {
                $value[$key] = $this->processAttribute($subValue);
            }

            return $value;
        }

        return $value;
    }

    protected function replaceString($string)
    {
        return preg_replace_callback('/#([a-z0-9\._]+)#/i', array($this, 'replaceSetting'), $string);
    }

    protected function replaceSetting($matches)
    {
        list($fullMatch, $path) = $matches;

        if ($this->settings->has($path)) {
            return $this->settings->get($path);
        }

        return $fullMatch;
    }
}
