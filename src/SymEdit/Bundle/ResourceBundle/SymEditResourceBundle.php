<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ResourceBundle;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\ResourceExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditResourceBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ResourceExtension();
    }
}
