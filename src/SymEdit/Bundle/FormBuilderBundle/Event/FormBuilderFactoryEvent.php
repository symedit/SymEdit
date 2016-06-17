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

class FormBuilderFactoryEvent extends Event
{
    protected $form;
    protected $options;

    public function __construct(FormInterface $form, array $options = [])
    {
        $this->form = $form;
        $this->options = $options;
    }

    /**
     * Get Form.
     *
     * @return FormInterface
     */
    public function getFormBuilder()
    {
        return $this->form;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    public function mergeOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
