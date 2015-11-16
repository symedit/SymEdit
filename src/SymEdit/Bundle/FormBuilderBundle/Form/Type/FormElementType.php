<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use SymEdit\Bundle\FormBuilderBundle\Builder\FieldBuilderRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormElementType extends AbstractType
{
    protected $registry;
    protected $class;

    public function __construct(FieldBuilderRegistry $registry, $class)
    {
        $this->registry = $registry;
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => false,
            ))
            ->add('type', HiddenType::class)
        ;

        $optionsBuilder = $builder->create('options', 'form');

        // Get builders from registry
        $fieldBuilders = $this->registry->getFieldBuilders($options['field_type']);

        foreach ($fieldBuilders as $fieldBuilder) {
            $fieldBuilder->buildOptionsForm($optionsBuilder);
        }

        // Add options to form
        $builder->add($optionsBuilder);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'field_type' => 'form',
            'data_class' => $this->class,
        ));
    }

    public function getName()
    {
        return 'symedit_form_element';
    }
}
