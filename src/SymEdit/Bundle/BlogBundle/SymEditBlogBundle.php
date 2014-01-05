<?php

namespace SymEdit\Bundle\BlogBundle;

use SymEdit\Bundle\BlogBundle\DependencyInjection\SymEditBlogExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditBlogBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SymEditBlogExtension();
    }
}
