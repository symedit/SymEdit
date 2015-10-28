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

use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

class FormBuilderEvent extends Event
{
    protected $formBuilder;
    protected $form;

    public function __construct(FormInterface $formBuilder, SymfonyFormInterface $form)
    {
        $this->formBuilder = $formBuilder;
        $this->form = $form;
    }

    /**
     * Get form builder model.
     *
     * @return FormInterface
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    /**
     * Get the Symfony Form.
     *
     * @return SymfonyFormInterface
     */
    public function getForm()
    {
        return $this->form;
    }
}
