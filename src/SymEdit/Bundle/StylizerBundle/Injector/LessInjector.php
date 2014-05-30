<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Injector;

class LessInjector extends AbstractInjector
{
    public function inject(array $variables = array())
    {
        $manager = $this->getFilterManager();

        if ($manager->has('less')) {
            $less = $manager->get('less');
            $less->setGlobalVariables($variables);
        }
    }
}
