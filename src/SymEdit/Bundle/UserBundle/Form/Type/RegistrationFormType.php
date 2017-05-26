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

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', [
                'label' => 'First Name',
                'property_path' => 'profile.firstName',
            ])
            ->add('lastName', 'text', [
                'label' => 'Last Name',
                'required' => false,
                'property_path' => 'profile.lastName',
            ])
        ;

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'symedit_user_registration';
    }
}
