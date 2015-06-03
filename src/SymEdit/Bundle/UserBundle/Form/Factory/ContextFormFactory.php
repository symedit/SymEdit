<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Form\Factory;

use FOS\UserBundle\Form\Factory\FactoryInterface;
use SymEdit\Bundle\UserBundle\Model\UserInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ContextFormFactory implements FactoryInterface
{
    protected $factory;
    protected $context;

    public function __construct(FormFactoryInterface $factory, TokenStorageInterface $context)
    {
        $this->factory = $factory;
        $this->context = $context;
    }

    public function createForm()
    {
        $type = sprintf('symedit_%s_profile', $this->getUser()->isAdmin() ? 'admin' : 'user');

        return $this->factory->createNamed('symedit_profile', $type);
    }

    /**
     * @return UserInterface $user
     */
    public function getUser()
    {
        return $this->context->getToken()->getUser();
    }
}
