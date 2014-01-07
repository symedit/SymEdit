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

class Layout
{
    private $rows;
    private $title;
    private $description;
    private $template;
    private $active;

    public function __construct($title, $description, array $rows = array())
    {
        $this->title = $title;
        $this->description = $description;
        $this->rows = array();
        $this->active = false;

        foreach ($rows as $row) {
            $this->addRow($row);
        }
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows(array $rows = array())
    {
        $this->rows = $rows;
    }

    public function addRow($row)
    {
        // If it's a string, make it an array of characters
        if (!is_array($row)) {
            $row = str_split($row);
        }

        $this->rows[] = $row;
    }
}
