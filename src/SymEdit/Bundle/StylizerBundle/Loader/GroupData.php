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

class GroupData
{
    private $name;
    private $variables;
    private $label;
    private $extra;

    public function __construct($name)
    {
        $this->name = $name;
        $this->extra = [];
        $this->variables = [];
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function addExtra(array $extra)
    {
        $this->extra = array_merge($this->extra, $extra);
    }

    public function getExtra()
    {
        return $this->extra;
    }

    public function addVariable($name, $data)
    {
        if (!is_array($data)) {
            $this->variables[$name] = [
                'value' => $data,
            ];
        } else {
            $this->variables[$name] = $data;
        }
    }

    public function addVariables(array $variables)
    {
        foreach ($variables as $name => $data) {
            $this->addVariable($name, $data);
        }
    }

    public function getVariables()
    {
        $variables = [];

        foreach ($this->variables as $name => $data) {
            $variables[$name] = $data['value'];
        }

        return $variables;
    }

    public function getVariableConfig()
    {
        return $this->variables;
    }
}
