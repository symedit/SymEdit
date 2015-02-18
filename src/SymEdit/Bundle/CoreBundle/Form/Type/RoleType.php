<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class RoleType extends AbstractType
{
    private $repository;
    private $context;

    public function __construct(RepositoryInterface $repository, SecurityContext $context)
    {
        $this->repository = $repository;
        $this->context = $context;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $roles = $this->repository->findAll();
        $choices = array();

        foreach ($roles as $role) {
            if ($this->context->isGranted($role->getRole())) {
                $choices[$role->getRole()] = $role->getDescription();
            }
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
            'multiple' => true,
            'expanded' => true,
            'required' => false,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'symedit_role';
    }
}
