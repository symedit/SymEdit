<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Form;

use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

interface FormBuilderFactoryInterface
{
    /**
     * Build form from form model.
     *
     * @param FormInterface $form
     * @param type          $data
     *
     * @return SymfonyFormInterface
     */
    public function build(FormInterface $form, $data = null);
}
