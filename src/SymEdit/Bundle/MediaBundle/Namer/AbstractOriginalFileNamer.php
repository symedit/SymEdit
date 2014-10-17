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

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractOriginalFileNamer implements NamerInterface
{
    public function getName(UploadedFile $file)
    {
        return $this->doGetName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
    }

    abstract protected function doGetName($name);
}
