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

use Symfony\Bundle\AsseticBundle\FilterManager;

class LessPhpInjector implements InjectorInterface
{
    public function inject(FilterManager $manager, array $variables = [])
    {
        if ($manager->has('lessphp')) {
            $lessphp = $manager->get('lessphp');
            $lessphp->setPresets($variables);
        }
    }
}
