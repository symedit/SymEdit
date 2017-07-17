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
    private $factory;
    private $context;
    private $userProfileFQCN;
    private $adminProfileFQCN;

    public function __construct(FormFactoryInterface $factory, TokenStorageInterface $context, $userProfileFQCN, $adminProfileFQCN)
    {
        $this->factory = $factory;
        $this->context = $context;
        $this->userProfileFQCN = $userProfileFQCN;
        $this->adminProfileFQCN = $adminProfileFQCN;
    }

    public function createForm()
    {
        $type = $this->getUser()->isAdmin() ? $this->adminProfileFQCN : $this->userProfileFQCN;

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
