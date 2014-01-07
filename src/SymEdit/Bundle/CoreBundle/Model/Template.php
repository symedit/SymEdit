<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

class Template
{
    private $layout;
    private $name;
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
