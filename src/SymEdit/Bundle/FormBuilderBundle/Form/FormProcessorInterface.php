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

use SymEdit\Bundle\FormBuilderBundle\Builder\FormBuilderResult;
use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

interface FormProcessorInterface
{
    /**
     * @param FormInterface        $model
     * @param SymfonyFormInterface $form
     *
     * @return FormBuilderResult
     */
    public function process(FormInterface $model, SymfonyFormInterface $form);
}
