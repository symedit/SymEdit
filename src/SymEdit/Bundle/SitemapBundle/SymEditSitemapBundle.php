<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle;

use SymEdit\Bundle\SitemapBundle\DependencyInjection\SymEditSitemapExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSitemapBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SymEditSitemapExtension();
    }
}
