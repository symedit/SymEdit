<?php

namespace Isometriks\Bundle\SymEditBundle\Iterator;

class RecursivePageIterator extends PageIterator implements \RecursiveIterator
{
    public function getChildren()
    {
        return $this->current()->getIterator();
    }

    public function hasChildren()
    {
        return count($this->current()->getChildren()) > 0;
    }
}