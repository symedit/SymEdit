<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

/**
 * @Todo: override the new buildUserForm method instead
 */
class UserProfileType extends BaseType
{
    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildUserForm($builder, $options);
    }

    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder
            ->add('firstName', 'text', array(
                'label' => 'First Name',
                'property_path' => 'profile.firstName',
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last Name',
                'required' => false,
                'property_path' => 'profile.lastName',
            ))
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Basic Tab
        $basic = $builder->create('basic', 'tab', array(
            'inherit_data' => true,
            'label' => 'Basic',
        ));

        $this->buildBasicForm($basic, $options);

        $builder
            ->add($basic)
        ;
    }

    public function getName()
    {
        return 'symedit_user_profile';
    }
}
