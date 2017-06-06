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

use SymEdit\Bundle\FormBuilderBundle\Builder\FieldBuilderRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FormElementType extends AbstractType
{
    protected $registry;

    public function __construct(FieldBuilderRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
            ])
            ->add('type', HiddenType::class)
        ;

        $optionsBuilder = $builder->create('options', FormType::class, [
            'embed_form' => true
         ]);

        // Get Field type
        $fieldType = $builder->getData()->getType();

        // Get builders from registry
        $fieldBuilders = $this->registry->getFieldBuilders($fieldType);

        foreach ($fieldBuilders as $fieldBuilder) {
            $fieldBuilder->buildOptionsForm($optionsBuilder);
        }

        // Add options to form
        $builder->add($optionsBuilder);
    }

    public function getBlockPrefix()
    {
        return 'symedit_form_element';
    }
}
