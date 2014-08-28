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

class ChainInjector extends AbstractInjector
{
    protected $injectors;

    public function __construct(array $injectors = array())
    {
        $this->injectors = $injectors;
    }

    public function inject(array $variables = array())
    {
        foreach ($this->injectors as $injector) {
            $injector->inject($variables);
        }
    }
}
