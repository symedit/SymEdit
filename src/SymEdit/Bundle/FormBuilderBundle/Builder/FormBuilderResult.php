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

use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

class FormBuilderResult implements FormBuilderResultInterface
{
    protected $model;
    protected $form;
    protected $pairs;
    protected $replyTo = [];

    public function __construct(FormInterface $model, SymfonyFormInterface $form)
    {
        $this->model = $model;
        $this->form = $form;
    }

    public function getData()
    {
        return $this->form->getData();
    }

    public function getForm()
    {
        return $this->form;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function addPair($label, $value)
    {
        $this->pairs[] = [
            'label' => $label,
            'value' => $value,
        ];
    }

    public function getPairs()
    {
        return $this->pairs;
    }

    public function addReplyTo($replyTo)
    {
        $this->replyTo[] = $replyTo;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }
}
