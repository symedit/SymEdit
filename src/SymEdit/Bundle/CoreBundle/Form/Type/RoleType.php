<?php

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\SecurityContext;

class RoleType extends AbstractType {

    private $doctrine;
    private $context;
    
    public function __construct(Registry $doctrine, SecurityContext $context)
    {
        $this->doctrine = $doctrine;
        $this->context = $context;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $roles = $this->doctrine->getManager()->getRepository('SymEdit\Bundle\CoreBundle\Model\Role')->findAll();
        $choices = array();

        foreach ($roles as $role) {
            if($this->context->isGranted($role->getRole())) {
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