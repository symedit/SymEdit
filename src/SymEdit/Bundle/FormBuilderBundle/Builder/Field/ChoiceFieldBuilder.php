<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Builder\Field;

use SymEdit\Bundle\FormBuilderBundle\Builder\FormBuilderResultInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class ChoiceFieldBuilder extends AbstractFieldBuilder
{
    public function buildOptionsForm(FormBuilderInterface $builder)
    {
        $choices = $builder
            ->create('choices', 'textarea', array(
                'required' => false,
                'attr' => array(
                    'rows' => 10,
                ),
                'help_block' => 'Separate choices by line.',
            ))
            ->addModelTransformer(new CallbackTransformer(
                function ($originalChoices) {
                    if ($originalChoices === null) {
                        return '';
                    }

                    return implode("\n", $originalChoices);
                },
                function ($submittedChoices) {
                    return array_map('trim', explode("\n", $submittedChoices));
                }
            ))
        ;

        $builder
            ->add($choices)
            ->add('expanded', 'checkbox', array(
                'required' => false,
                'help_block' => 'Using "expanded" will use checkboxes or radio buttons depending on value of "multiple."',
            ))
            ->add('multiple', 'checkbox', array(
                'required' => false,
                'help_block' => 'Allow multiple choices to be chosen.',
            ))
        ;
    }

    public function processResult(FormBuilderResultInterface $result, FormElementInterface $formElement, $value)
    {
        $choices = $formElement->getOption('choices');
        $selectedKeys = (array)$value;
        $selected = array();

        foreach ($selectedKeys as $selectedId) {
            $selected[$selectedId] = $choices[$selectedId];
        }

        return $selected;
    }
}
