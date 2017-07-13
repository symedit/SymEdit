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

interface FormElementConfigInterface
{
    /**
     * @return FormElementInterface
     */
    public function getFormElement();

    public function getType();

    public function setType($type);

    public function setFormFQCN($formFQCN);

    public function getFormFQCN();

    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    public function getConstraints();

    public function addConstraint(Constraint $constraint);
}
