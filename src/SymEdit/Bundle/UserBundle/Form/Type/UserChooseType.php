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

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserChooseType extends AbstractType
{
    protected $userClass;

    public function __construct($userClass)
    {
        $this->userClass = $userClass;
    }

    public function getParent()
    {
        return EntityType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Set Defaults
        $resolver->setDefaults([
            'class' => $this->userClass,
            'admin' => false,
        ]);

        // Query builder relies on option so create callback
        $resolver->setDefault('query_builder', function (Options $options) {
            $closure = function (EntityRepository $er) use ($options) {
                return $er->createQueryBuilder('u')
                    ->andWhere('u.admin = :admin')
                    ->setParameter('admin', $options['admin'])
                ;
            };

            return $closure;
        });
    }

    public function getBlockPrefix()
    {
        return 'symedit_user_choose';
    }
}
