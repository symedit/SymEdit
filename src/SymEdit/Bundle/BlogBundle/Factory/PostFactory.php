<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostFactory implements FactoryInterface
{
    private $decoratedFactory;
    private $tokenStorage;

    public function __construct(FactoryInterface $decoratedFactory, TokenStorageInterface $tokenStorage)
    {
        $this->decoratedFactory = $decoratedFactory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return PostInterface
     */
    public function createNew()
    {
        return $this->decoratedFactory->createNew();
    }

    public function createWithUser()
    {
        $post = $this->createNew();
        $token = $this->tokenStorage->getToken();

        if ($token === null) {
            return $post;
        }

        $user = $token->getUser();

        if ($user === null) {
            return $post;
        }

        // We do have a current user
        $post->setAuthor($user);

        return $post;
    }
}