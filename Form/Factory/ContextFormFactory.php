<?php

namespace Isometriks\Bundle\SymEditBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ContextFormFactory
{
    protected $factory;
    protected $context;

    public function __construct(FormFactoryInterface $factory, SecurityContext $context)
    {
        $this->factory = $factory;
        $this->context = $context;
    }

    public function createForm($adminType, $userType, $name)
    {
        $type = $this->getUser()->isAdmin() ? $adminType : $userType;

        return $this->factory->createNamed($name, $type);
    }

    /**
     * @return \Isometriks\Bundle\SymEditBundle\Model\UserInterface $user
     */
    public function getUser()
    {
        return $this->context->getToken()->getUser();
    }
}