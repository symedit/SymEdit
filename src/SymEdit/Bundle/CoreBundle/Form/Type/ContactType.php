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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'Name',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('email', 'email', array(
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Email',
                ),
                'constraints' => array(
                    new Email(),
                ),
            ))
            ->add('phone', 'text', array(
                'label' => 'Phone',
                'attr' => array(
                    'placeholder' => 'Phone',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('message', 'textarea', array(
                'label' => 'Message',
                'attr' => array(
                    'rows' => 5,
                    'placeholder' => 'Your Message',
                ),
                'constraints' => array(
                    new NotBlank(),
                ),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'horizontal' => false,
            'timed_spam' => true,
            'honeypot' => true,
        ));
    }

    public function getName()
    {
        return 'symedit_contact';
    }
}
