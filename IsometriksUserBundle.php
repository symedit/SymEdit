<?php

namespace Isometriks\Bundle\UserBundle; 

use Symfony\Component\HttpKernel\Bundle\Bundle; 

class IsometriksUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}