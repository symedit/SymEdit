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
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$builder->has('basic')) {
            return;
        }

        $basic = $builder->get('basic');

        /*
         * Don't require current password.
         */
        if ($basic->has('current_password')) {
            $basic->remove('current_password');
        }

        /*
         * This subscriber will require / unrequire the plainPassword field
         * depending on if it's a new user or existing.
         */
        $builder->addEventSubscriber(new UserTypeSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('tabs_class', 'nav nav-tabs');
    }

    public function getParent()
    {
        return 'symedit_admin_profile';
    }

    public function getBlockPrefix()
    {
        return 'symedit_user';
    }
}
