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

use Sylius\Component\Resource\Model\ResourceInterface;

interface FormElementInterface extends ResourceInterface
{
    /**
     * @return string Get form element id
     */
    public function getId();

    /**
     * @return string Get form element type
     */
    public function getType();

    /**
     * @return string|null Form Element Name
     */
    public function getName();

    /**
     * @param string|null $name
     */
    public function setName($name);

    /**
     * Set form element type.
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * @return FormInterface
     */
    public function getForm();

    /**
     * Set form.
     *
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form);

    /**
     * Get position order
     *
     * @return int Position
     */
    public function getPosition();

    /**
     * Set order position.
     *
     * @param int $position
     */
    public function setPosition($position);

    /**
     * Set options for form element.
     *
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * @return array $options
     */
    public function getOptions();

    /**
     * Get an extra option.
     *
     * @return mixed
     */
    public function getExtra($extra, $default = null);

    /**
     * Set an extra value.
     *
     * @param string $extra
     * @param mixed  $value
     */
    public function setExtra($extra, $value);

    /**
     * Get single value from options.
     *
     * @param string $option Option to get.
     *
     * @return mixed Get option value.
     */
    public function getOption($option);
}
