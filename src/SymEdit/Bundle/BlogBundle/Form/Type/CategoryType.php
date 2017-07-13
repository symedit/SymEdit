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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('title', TextType::class, [
                'label' => 'symedit.form.category.title',
            ])
            ->add('name', TextType::class, [
                'label' => 'symedit.form.category.name.label',
                'help_block' => 'symedit.form.category.name.help',
            ])
            ->add('parent', 'entity', [
                'label' => 'symedit.form.category.parent.label',
                'empty_value' => 'symedit.form.category.parent.empty',
                'class' => $this->class,
                'required' => false,
            ])
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildBasicForm($builder, $options);
    }

    public function getBlockPrefix()
    {
        return 'symedit_category';
    }
}
