<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Form\Factory\FactoryInterface;

class ContextFormFactory implements FactoryInterface
{
    protected $factory;
    protected $context;
    protected $options;

    public function __construct(FormFactoryInterface $factory, SecurityContext $context, array $options)
    {
        $this->factory = $factory;
        $this->context = $context;
        $this->options = $options;
    }

    public function createForm()
    {
        $type = $this->getUser()->isAdmin() ? $this->options['adminType'] : $this->options['userType'];

        return $this->factory->createNamed($this->options['name'], $type);
    }

    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\UserInterface $user
     */
    public function getUser()
    {
        return $this->context->getToken()->getUser();
    }
}
