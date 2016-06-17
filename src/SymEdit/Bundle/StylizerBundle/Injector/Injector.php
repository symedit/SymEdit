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

class Injector
{
    protected $manager;
    protected $injectors;

    public function __construct(FilterManager $manager, array $injectors = [])
    {
        $this->manager = $manager;
        $this->injectors = $injectors;
    }

    public function inject(array $variables = [])
    {
        foreach ($this->injectors as $injector) {
            $injector->inject($this->manager, $variables);
        }
    }
}
