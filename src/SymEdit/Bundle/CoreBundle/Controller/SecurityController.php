<?php

namespace SymEdit\Bundle\CoreBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        return $this->container->get('templating')->renderResponse(
            '@SymEdit/Security/login.html.twig',
            $data
        );
    }
}
