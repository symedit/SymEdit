<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Builder\Field;

use SymEdit\Bundle\FormBuilderBundle\Builder\FormBuilderResultInterface;
use SymEdit\Bundle\FormBuilderBundle\Builder\FormElementConfig;
use SymEdit\Bundle\FormBuilderBundle\Builder\FormElementConfigInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use Symfony\Component\Form\FormBuilderInterface;

interface FormFieldBuilderInterface
{
    /**
     * Build Form Options.
     *
     * @param FormBuilderInterface $builder
     */
    public function buildOptionsForm(FormBuilderInterface $builder);

    /**
     * Process result.
     *
     * @param FormBuilderResultInterface $result
     */
    public function processResult(FormBuilderResultInterface $result, FormElementInterface $formElement, $value);

    /**
     * Build Form Config.
     *
     * @param FormElementConfig $config
     */
    public function buildFormConfig(FormElementConfigInterface $config);

    /**
     * Get FQCN Of Form Type
     */
    public function getFormFQCN();

    /**
     * Get Parent.
     *
     * @return string
     */
    public function getParent();
}
