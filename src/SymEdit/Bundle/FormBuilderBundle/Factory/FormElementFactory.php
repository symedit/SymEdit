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
use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;

class FormElementFactory implements FormElementFactoryInterface
{
    private $defaultFactory;
    private $formBuilderRepository;

    public function __construct(FactoryInterface $defaultFactory, RepositoryInterface $formBuilderRepository)
    {
        $this->defaultFactory = $defaultFactory;
        $this->formBuilderRepository = $formBuilderRepository;
    }

    /**
     * @return FormElementInterface
     */
    public function createNew()
    {
        return $this->defaultFactory->createNew();
    }

    /**
     * @return FormElementInterface
     */
    public function createWithBuilder($type, $formBuilderId)
    {
        $formElement = $this->createNew();
        $formBuilder = $this->formBuilderRepository->find($formBuilderId);
        $formElement->setForm($formBuilder);
        $formElement->setType($type);

        return $formElement;
    }
}
