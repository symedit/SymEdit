<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Model;

class FormElement implements FormElementInterface
{
    protected $id;
    protected $type;
    protected $name;
    protected $position;
    protected $options = [];
    protected $form;

    public function getId()
    {
        return $this->id;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOption($option)
    {
        return $this->options[$option];
    }

    public function getExtra($extra, $default = null)
    {
        if (isset($this->options['extra']) && isset($this->options['extra'][$extra])) {
            return $this->options['extra'][$extra];
        }

        return $default;
    }

    public function setExtra($extra, $value)
    {
        if (!isset($this->options['extra'])) {
            $this->options['extra'] = [];
        }

        $this->options['extra'][$extra] = $value;

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setForm(FormInterface $form)
    {
        $this->form = $form;

        return $this;
    }
}
