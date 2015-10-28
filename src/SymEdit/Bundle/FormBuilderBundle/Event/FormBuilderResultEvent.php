<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Event;

use SymEdit\Bundle\FormBuilderBundle\Builder\FormBuilderResultInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

class FormBuilderResultEvent extends Event
{
    protected $result;

    public function __construct(FormBuilderResultInterface $result)
    {
        $this->result = $result;
    }

    /**
     * Get Form Result.
     *
     * @return FormBuilderResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Get form builder model.
     *
     * @return FormInterface
     */
    public function getFormBuilder()
    {
        return $this->result->getModel();
    }

    /**
     * Get the Symfony Form.
     *
     * @return SymfonyFormInterface
     */
    public function getForm()
    {
        return $this->result->getForm();
    }
}
