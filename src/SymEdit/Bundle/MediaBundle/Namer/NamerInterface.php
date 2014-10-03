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

interface NamerInterface
{
    public function getName(UploadedFile $file);
}
