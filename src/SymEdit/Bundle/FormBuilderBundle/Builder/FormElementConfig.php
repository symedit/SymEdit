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

use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use Symfony\Component\Validator\Constraint;

class FormElementConfig implements FormElementConfigInterface
{
    protected $element;
    protected $type;
    protected $formFQCN;
    protected $name;
    protected $constraints = [];

    public function __construct(FormElementInterface $element)
    {
        $this->element = $element;
    }

    public function addConstraint(Constraint $constraint)
    {
        $this->constraints[] = $constraint;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getFormFQCN()
    {
        return $this->formFQCN;
    }

    public function setFormFQCN($formFQCN)
    {
        $this->formFQCN = $formFQCN;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getFormElement()
    {
        return $this->element;
    }
}
