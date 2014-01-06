<?php

namespace SymEdit\Bundle\SettingsBundle\EventListener;

use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

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