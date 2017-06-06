<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Form\Type;

use SymEdit\Bundle\WidgetBundle\Form\DataTransformer\WidgetAssociationTransformer;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class WidgetType extends AbstractType
{
    protected $registry;
    protected $widgetAreaClass;

    public function __construct(WidgetRegistry $registry, $widgetAreaClass)
    {
        $this->registry = $registry;
        $this->widgetAreaClass = $widgetAreaClass;
    }

    public function buildBasicForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new WidgetAssociationTransformer();

        $builder
            ->add('title', TextType::class, [
                'label' => 'symedit.form.widget.basic.title',
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'label' => 'symedit.form.widget.basic.name.label',
                'help_block' => 'symedit.form.widget.basic.name.help',
            ])
            ->add('area', EntityType::class, [
                'label' => 'symedit.form.widget.basic.area',
                'choice_label' => 'area',
                'class' => $this->widgetAreaClass,
            ])
            ->add('visibility', ChoiceType::class, [
                'label' => 'symedit.form.widget.basic.visibility.label',
                'choices' => [
                    'symedit.form.widget.basic.visibility.include_all' => WidgetInterface::INCLUDE_ALL,
                    'symedit.form.widget.basic.visibility.include_only' => WidgetInterface::INCLUDE_ONLY,
                    'symedit.form.widget.basic.visibility.exclude_only' => WidgetInterface::EXCLUDE_ONLY,
                ],
            ])
            ->add(
                $builder->create('assoc', TextareaType::class, [
                    'label' => 'symedit.form.widget.basic.associations',
                    'required' => false,
                    'auto_initialize' => false,
                    'attr' => [
                        'rows' => 8,
                    ],
                ])->addModelTransformer($transformer)
            )
        ;
    }

    public function buildOptionsForm(FormBuilderInterface $builder, array $options, WidgetInterface $originalData)
    {
        $strategy = $this->registry->getStrategy($originalData->getStrategyName());

        // Add custom template override
        $builder
            ->add('template', TextType::class, [
                'required' => true,
                'help_block' => 'symedit.form.widget.options.template.help',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;

        $strategy->buildForm($builder);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildBasicForm($builder, $options);
        $this->buildOptionsForm($builder, $options, $builder->getData());
    }

    public function getBlockPrefix()
    {
        return 'symedit_widget';
    }
}
