<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Model;

class Template implements TemplateInterface
{
    protected $key;
    protected $path;
    protected $layout;

    public function __construct($key, $path, Layout $layout = null)
    {
        $this->key = $key;
        $this->path = $path;
        $this->layout = $layout;
    }

    public function __toString()
    {
        return $this->key;
    }

    public function getType()
    {
        $parts = explode('/', ltrim($this->getKey(), '/'), 2);

        if (count($parts) === 1) {
            return null;
        }

        return $parts[0];
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @return Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
