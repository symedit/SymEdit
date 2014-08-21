<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;

class SubscribeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // If there is a list in the data use that
        if ($builder->getData() !== null) {
            $options = array();
        } else {
            $options = array(
                'data' => $options['list'],
            );
        }

        $builder
            ->add('email', 'email', array(
                'constraints' => array(
                    new Email(),
                ),
            ))
            ->add('list', 'hidden', $options)
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'list' => null,
        ));
    }

    public function getName()
    {
        return 'mailchimp_subscribe';
    }
}
