<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Model;

class Styles implements \ArrayAccess
{
    private $variables;

    public function __construct(array $variables = [])
    {
        $this->variables = $variables;
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function setVariables(array $variables)
    {
        $this->variables = $variables;
    }

    public function offsetExists($offset)
    {
        return isset($this->variables[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception(sprintf('Variables "%s" does not exist.', $offset));
        }

        return $this->variables[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->variables[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->variables[$offset]);
    }
}
