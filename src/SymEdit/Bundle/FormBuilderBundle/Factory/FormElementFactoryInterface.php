<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;

interface FormElementFactoryInterface extends FactoryInterface
{
    /**
     * @return FormElementInterface
     */
    public function createWithBuilder($type, $formBuilderId);
}
