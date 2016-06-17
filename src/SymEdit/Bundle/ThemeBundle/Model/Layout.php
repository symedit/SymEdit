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

class Layout
{
    protected $key;
    protected $title;
    protected $description;
    protected $rows;

    public function __construct($key, $title = null, $description = null, $rows = null)
    {
        $this->key = $key;
        $this->title = $title;
        $this->description = $description;
        $this->rows = [];

        if (is_array($rows)) {
            foreach ($rows as $row) {
                $this->addRow($row);
            }
        }
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

    public function setRows(array $rows = [])
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
