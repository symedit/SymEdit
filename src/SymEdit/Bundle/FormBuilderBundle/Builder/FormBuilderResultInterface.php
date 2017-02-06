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

use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

interface FormBuilderResultInterface
{
    /**
     * Add a reply to address.
     *
     * @param string|array $replyTo
     */
    public function addReplyTo($replyTo);

    /**
     * @return array Reply to addresses
     */
    public function getReplyTo();

    /**
     * Get Symfony Form Data.
     *
     * @return array
     */
    public function getData();

    /**
     * Add A Pair.
     *
     * @param string $label
     * @param mixed  $value
     */
    public function addPair($label, $value);

    /**
     * Get Data paired with form labels.
     *
     * @return array
     */
    public function getPairs();

    /**
     * Get Underlying SymEdit Model Class.
     *
     * @return FormInterface
     */
    public function getModel();

    /**
     * Gets Symfony Form.
     *
     * @return SymfonyFormInterface
     */
    public function getForm();
}
