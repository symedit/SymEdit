<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use SymEdit\Bundle\CoreBundle\Form\EventListener\UserTypeSubscriber;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!$builder->has('basic')){
            return;
        }

        $basic = $builder->get('basic');

        /**
         * Don't require current password.
         */
        if($basic->has('current_password')){
            $basic->remove('current_password');
        }

        /**
         * This subscriber will require / unrequire the plainPassword field
         * depending on if it's a new user or existing.
         */
        $builder->addEventSubscriber(new UserTypeSubscriber());
    }

    public function getParent()
    {
        return 'isometriks_symedit_admin_profile';
    }

    public function getName()
    {
        return 'isometriks_symedit_user';
    }
}