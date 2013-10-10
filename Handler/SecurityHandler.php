<?php

namespace Isometriks\Bundle\SymEditBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class SecurityHandler implements AuthenticationSuccessHandlerInterface
{
    private $router;
    private $context;

    public function __construct(Router $router, SecurityContext $context)
    {
        $this->router = $router;
        $this->context = $context;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if($this->context->isGranted('ROLE_ADMIN')){
            $url = $this->router->generate('admin_dashboard');
        } else {
            if($request->request->has('_target_path')) {
                $url = $request->request->get('_target_path');
            } else {
                $url = $this->router->generate('homepage');
            }
        }

        return new RedirectResponse($url);
    }
}