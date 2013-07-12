<?php

namespace Isometriks\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        return $this->container->get('templating')->renderResponse(
            'IsometriksSymEditBundle:Security:login.html.twig',
            $data
        );
    }
}