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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserChooseType extends AbstractType
{
    protected $userClass;

    public function __construct($userClass)
    {
        $this->userClass = $userClass;
    }

    public function getParent()
    {
        return 'entity';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->userClass,
            'admin' => false,
        ));

        $resolver->setNormalizers(array(
            'query_builder' => function (Options $options, $value) {
                return function (EntityRepository $er) use ($options) {
                           return $er->createQueryBuilder('u')
                                     ->andWhere('u.admin = :admin')
                                     ->setParameter('admin', $options['admin'])
                                  ;
                       };
            },
        ));
    }

    public function getName()
    {
        return 'symedit_user_choose';
    }
}
