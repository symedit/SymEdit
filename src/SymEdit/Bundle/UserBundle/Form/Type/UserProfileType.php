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

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Mopa\Bundle\BootstrapBundle\Form\Type\TabType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @Todo: override the new buildUserForm method instead
 */
class UserProfileType extends BaseType
{
    protected function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'property_path' => 'profile.firstName',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'required' => false,
                'property_path' => 'profile.lastName',
            ])
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Basic Tab
        $basic = $builder->create('basic', TabType::class, [
            'inherit_data' => true,
            'label' => 'Basic',
        ]);

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
