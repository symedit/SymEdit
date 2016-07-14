<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Loader;

class ConfigData implements \Serializable
{
    private $groups = [];

    public function parseGroup($name, $data)
    {
        if (!isset($this->groups[$name])) {
            $this->groups[$name] = new GroupData($name);
        }

        $group = $this->groups[$name];

        /*
         * Allow overriding labels
         */
        if (isset($data['label'])) {
            $group->setLabel($data['label']);
        }

        /*
         * Add optional arguments
         */
        if (isset($data['extra'])) {
            $group->addExtra($data['extra']);
        }

        if (isset($data['variables'])) {
            $group->addVariables($data['variables']);
        }
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function getVariables()
    {
        $variables = [];

        foreach ($this->getGroups() as $group) {
            $variables = array_merge($variables, $group->getVariables());
        }

        return $variables;
    }

    public function serialize()
    {
        return serialize($this->groups);
    }

    public function unserialize($serialized)
    {
        $this->groups = unserialize($serialized);
    }
}
