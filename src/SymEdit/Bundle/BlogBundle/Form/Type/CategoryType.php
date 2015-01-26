<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class CategoryType extends AbstractType
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('name', 'text', array(
                'label' => 'Slug',
                'help_block' => 'Lowercase, numbers, hyphens and underscores.',
            ))
            ->add('parent', 'entity', array(
                'empty_value' => '(Root Category)',
                'class' => $this->class,
                'required' => false,
            ))
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildBasicForm($builder, $options);
    }

    public function getName()
    {
        return 'symedit_category';
    }
}
