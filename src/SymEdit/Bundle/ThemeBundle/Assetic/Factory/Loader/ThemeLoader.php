<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Assetic\Factory\Loader;

use Assetic\Factory\Loader\FormulaLoaderInterface;
use Assetic\Factory\Resource\ResourceInterface;
use SymEdit\Bundle\ThemeBundle\Assetic\Factory\Resource\ThemeResource;

class ThemeLoader implements FormulaLoaderInterface
{
    public function load(ResourceInterface $resource)
    {
        return $resource instanceof ThemeResource ? $resource->getContent() : [];
    }
}
