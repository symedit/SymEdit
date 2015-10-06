<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormBuilderInterface;

class DisplayOptionsEvent extends Event
{
    protected $builder;
    protected $options;

    public function __construct(FormBuilderInterface $builder, array $options)
    {
        $this->builder = $builder;
        $this->options = $options;
    }

    /**
     * Get Form Builder.
     *
     * @return FormBuilderInterface
     */
    public function getFormBuilder()
    {
        return $this->builder;
    }

    /**
     * Get Passed Form Options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
