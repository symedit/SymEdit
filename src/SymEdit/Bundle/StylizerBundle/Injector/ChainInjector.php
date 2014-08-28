<?php

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
