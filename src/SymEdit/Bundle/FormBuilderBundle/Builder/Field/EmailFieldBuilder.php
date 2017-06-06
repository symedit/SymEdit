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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;

class EmailFieldBuilder extends AbstractFieldBuilder
{
    public function buildOptionsForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('placeholder', TextType::class, [
                'required' => false,
                'property_path' => '[attr][placeholder]',
            ])
            ->add('replyTo', CheckboxType::class, [
                'required' => false,
                'property_path' => '[extra][replyTo]',
                'help_block' => 'If filled, use as a reply-to field so notification emails will reply to this address.',
            ])
        ;
    }

    public function processResult(FormBuilderResultInterface $result, FormElementInterface $formElement, $value)
    {
        if ($formElement->getExtra('replyTo', false) && $value !== null) {
            $result->addReplyTo($value);
        }

        return parent::processResult($result, $formElement, $value);
    }

    public function buildFormConfig(FormElementConfigInterface $config)
    {
        $config->addConstraint(new Email());
    }

    public function getFormFQCN()
    {
        return EmailType::class;
    }

    public function getParent()
    {
        return 'text';
    }
}
