<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoExportBundle;

use SymEdit\Bundle\SeoExportBundle\DependencyInjection\SymEditSeoExportExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditSeoExportBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new SymEditSeoExportExtension();
    }
}
