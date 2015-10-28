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

use Doctrine\Common\Collections\ArrayCollection;

class Form implements FormInterface
{
    protected $id;
    protected $name;
    protected $legend;
    protected $elements;
    protected $updatedAt;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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

    public function getLegend()
    {
        return $this->legend;
    }

    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    public function addFormElement(FormElementInterface $element)
    {
        $this->setUpdated();

        // Set reverse relation
        $element->setForm($this);

        // Add element
        $this->elements->add($element);

        return $this;
    }

    public function removeFormElement(FormElementInterface $element)
    {
        $this->setUpdated();
        $this->elements->remove($element);

        return $this;
    }

    public function getFormElements()
    {
        return $this->elements;
    }

    public function setFormElements(ArrayCollection $elements)
    {
        $this->elements = $elements;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    protected function setUpdated()
    {
        $this->setUpdatedAt(new \DateTime());

        return $this;
    }
}
