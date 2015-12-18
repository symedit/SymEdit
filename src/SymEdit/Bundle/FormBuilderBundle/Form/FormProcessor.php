<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Form;

use SymEdit\Bundle\FormBuilderBundle\Builder\FieldBuilderRegistry;
use SymEdit\Bundle\FormBuilderBundle\Builder\FormBuilderResult;
use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

class FormProcessor implements FormProcessorInterface
{
    protected $registry;

    public function __construct(FieldBuilderRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function process(FormInterface $model, SymfonyFormInterface $form)
    {
        $result = new FormBuilderResult($model, $form);
        $data = $form->getData();

        foreach ($model->getFormElements() as $element) {
            $options = $element->getOptions();
            $config = $this->registry->getFormElementConfig($element);
            $label = isset($options['label']) ? $options['label'] : sprintf('Element %d', $element->getId());
            $value = $data[$config->getName()];

            // Let field modify result if needed
            $field = $this->registry->getFieldBuilder($element->getType());
            $value = $field->processResult($result, $element, $value);

            $result->addPair($label, $value);
        }

        return $result;
    }
}
