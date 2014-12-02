<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Namer;

class SlugNamer extends AbstractOriginalFileNamer
{
    protected function doGetName($name)
    {
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $clean = preg_replace('/[^a-zA-Z0-9\/_|+ -]/', '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace('/[\/_|+ -]+/', '-', $clean);

        return $clean;
    }
}
