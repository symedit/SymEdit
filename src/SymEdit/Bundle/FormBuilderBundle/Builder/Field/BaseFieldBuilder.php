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

use SymEdit\Bundle\FormBuilderBundle\Builder\FormElementConfigInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class BaseFieldBuilder extends AbstractFieldBuilder
{
    public function buildOptionsForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('label', TextType::class, [
                'required' => false,
                'property_path' => '[label]',
            ])
            ->add('required', CheckboxType::class, [
                'required' => false,
                'property_path' => '[required]',
            ])
        ;
    }

    public function buildFormConfig(FormElementConfigInterface $config)
    {
        $element = $config->getFormElement();

        // Set Form Element Type
        $config->setType($element->getType());

        // Set Form Element Name
        $name = $element->getName();
        $name = empty($name) ? $element->getId() : $element->getName();
        $config->setName($name);

        if ($element->getOption('required')) {
            $config->addConstraint(new NotBlank());
        }
    }

    /**
     * Should be unreachable.
     */
    public function getFormFQCN()
    {
        return;
    }
}
