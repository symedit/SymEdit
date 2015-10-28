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
use Symfony\Component\Validator\Constraints\Email;

class EmailFieldBuilder extends AbstractFieldBuilder
{
    public function buildOptionsForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('placeholder', 'text', array(
                'required' => false,
                'property_path' => '[attr][placeholder]',
            ))
            ->add('replyTo', 'checkbox', array(
                'required' => false,
                'property_path' => '[extra][replyTo]',
            ))
        ;
    }

    public function processResult(FormBuilderResultInterface $result, FormElementInterface $formElement, $value)
    {
        if ($formElement->getExtra('replyTo', false) && $value !== null) {
            $result->addReplyTo($value);
        }
    }

    public function buildFormConfig(FormElementConfigInterface $config)
    {
        $config->addConstraint(new Email());
    }

    public function getParent()
    {
        return 'text';
    }
}
