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
use Sylius\Component\Resource\Model\ResourceInterface;

interface FormInterface extends ResourceInterface
{
    /**
     * @return int Form ID
     */
    public function getId();

    /**
     * Slug.
     *
     * @return string Unique slug for form name to be used in urls
     */
    public function getName();

    public function setName($name);

    public function getLegend();

    public function setLegend($legend);

    /**
     * @return FormElementInterface[]|ArrayCollection
     */
    public function getFormElements();

    public function setFormElements(ArrayCollection $elements);

    public function addFormElement(FormElementInterface $element);

    public function removeFormElement(FormElementInterface $element);

    /**
     * Set the updated time.
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return \DateTime Time updated
     */
    public function getUpdatedAt();
}
