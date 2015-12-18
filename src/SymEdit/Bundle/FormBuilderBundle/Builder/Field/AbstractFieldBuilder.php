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
use SymEdit\Bundle\FormBuilderBundle\Builder\FormElementConfigInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractFieldBuilder implements FormFieldBuilderInterface
{
    public function buildOptionsForm(FormBuilderInterface $builder)
    {
    }

    public function processResult(FormBuilderResultInterface $result, FormElementInterface $formElement, $value)
    {
        return $value;
    }

    public function buildFormConfig(FormElementConfigInterface $config)
    {
    }

    public function getParent()
    {
        return;
    }
}
