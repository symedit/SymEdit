<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Annotation;

/**
 * @Annotation
 */
class PageController
{
    private $name;
    private $default;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $key;
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(
                    sprintf("Unknown property '%s' on annotation '%s'.", $key, get_class($this))
                );
            }
            $this->$method($value);
        }
    }

    public function setDefault($default)
    {
        $this->default = $default;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
