<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Iterator;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;

class PageIterator implements \Iterator
{
    protected $children;
    protected $display;
    protected $position;
    protected $length;

    public function __construct(PageInterface $page, $display = true)
    {
        $this->children = $page->getChildren();
        $this->length = count($this->children);
        $this->display = $display;
        $this->rewind();
    }

    /**
     * @return PageInterface
     */
    public function current()
    {
        return $this->children[$this->position];
    }

    public function key()
    {
        return $this->current()->getId();
    }

    public function next()
    {
        ++$this->position;

        while ($this->position < $this->length) {
            if ($this->valid()) {
                break;
            }

            ++$this->position;
        }
    }

    public function rewind()
    {
        $this->position = -1;
        $this->next();
    }

    public function valid()
    {
        if (!isset($this->children[$this->position])) {
            return false;
        }

        return !$this->display || $this->current()->getDisplay();
    }
}
