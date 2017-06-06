<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Builder;

use SymEdit\Bundle\FormBuilderBundle\Builder\Field\FormFieldBuilderInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;

class FieldBuilderRegistry
{
    protected $baseBuilder;
    protected $fields;

    public function __construct(FormFieldBuilderInterface $baseBuilder, $fields = [])
    {
        $this->baseBuilder = $baseBuilder;
        $this->fields = $fields;
    }

    /**
     * @return FormFieldBuilderInterface
     */
    public function getFieldBuilder($type)
    {
        return $this->fields[$type];
    }

    /**
     * Gets all builders for a type.
     *
     * @param string $type
     *
     * @return FormFieldBuilderInterface[]
     */
    public function getFieldBuilders($type)
    {
        $fieldBuilder = $this->getFieldBuilder($type);
        $builders = [$fieldBuilder];

        while ($fieldBuilder->getParent() !== null) {
            $fieldBuilder = $this->getFieldBuilder($fieldBuilder->getParent());
            array_unshift($builders, $fieldBuilder);
        }

        // Add Base Builder
        array_unshift($builders, $this->baseBuilder);

        return $builders;
    }

    public function getFormElementConfig(FormElementInterface $element)
    {
        $config = new FormElementConfig($element);
        $typeBuilder = $this->getFieldBuilder($element->getType());
        $config->setFormFQCN($typeBuilder->getFormFQCN());
        $builders = $this->getFieldBuilders($element->getType());

        foreach ($builders as $builder) {
            $builder->buildFormConfig($config);
        }

        return $config;
    }

    public function getTypes()
    {
        return array_keys($this->fields);
    }
}
