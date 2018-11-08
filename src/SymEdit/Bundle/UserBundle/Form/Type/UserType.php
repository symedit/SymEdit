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

use SymEdit\Bundle\UserBundle\Form\EventListener\UserTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
         * Don't require current password.
         */
        if ($builder->has('current_password')) {
            $builder->remove('current_password');
        }

        /*
         * This subscriber will require / unrequire the plainPassword field
         * depending on if it's a new user or existing.
         */
        $builder->addEventSubscriber(new UserTypeSubscriber());
    }

    public function getParent()
    {
        return AdminProfileType::class;
    }

    public function getBlockPrefix()
    {
        return 'symedit_user';
    }
}
