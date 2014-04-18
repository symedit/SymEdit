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

interface TemplateInterface
{
    public function getKey();
    public function setKey($key);
    public function setPath($path);
    public function getPath();
    public function setLayout(Layout $layout);
    public function getLayout();
}
