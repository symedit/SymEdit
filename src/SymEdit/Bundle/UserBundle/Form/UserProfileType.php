<?php

namespace Isometriks\Bundle\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'inherit_data' => true,
            'label' => 'Basic',
        ));

        parent::buildForm($basic, $options);

        $basic
            ->add('firstName', 'text', array(
                'label' => 'First Name',
                'property_path' => 'profile.firstName',
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last Name',
                'required' => false,
                'property_path' => 'profile.lastName',
            ));

        $builder
            ->add($basic);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'tabs_class' => 'nav nav-pills nav-stacked',
        ));
    }

    public function getName()
    {
        return 'isometriks_symedit_user_profile';
    }

}