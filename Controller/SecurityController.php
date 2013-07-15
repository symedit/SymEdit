<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        return $this->container->get('templating')->renderResponse(
            '@IsometriksSymEdit/Security/login.html.twig',
            $data
        );
    }
}