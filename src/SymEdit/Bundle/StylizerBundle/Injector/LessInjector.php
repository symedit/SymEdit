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

class LessInjector implements InjectorInterface
{
    public function inject(FilterManager $manager, array $variables = [])
    {
        if ($manager->has('less')) {
            $less = $manager->get('less');
            $less->addParserOption('globalVars', $this->sanitize($variables));
        }
    }

    protected function sanitize(array $variables)
    {
        return array_map(function ($variable) {
            if (strpos($variable, '/') !== false) {
                return '"'.$variable.'"';
            }

            return $variable;
        }, $variables);
    }
}
