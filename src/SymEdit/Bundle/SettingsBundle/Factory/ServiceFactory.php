<?php

namespace SymEdit\Bundle\SettingsBundle\Factory;

use SymEdit\Bundle\SettingsBundle\Model\Settings;

class ServiceFactory
{
    protected $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function create($className, array $arguments)
    {
        $resolvedArguments = array();

        foreach ($arguments as $argument) {
            if (is_string($argument) && $argument[0] === '$' && $this->settings->has(substr($argument, 1))) {
                $argument = $this->settings->get(substr($argument, 1));
            }

            $resolvedArguments[] = $argument;
        }

        $class = new \ReflectionClass($className);

        return $class->newInstanceArgs($resolvedArguments);
    }
}