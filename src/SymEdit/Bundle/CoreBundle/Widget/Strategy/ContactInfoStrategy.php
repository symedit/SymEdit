<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Repository\ParameterRepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactInfoStrategy extends AbstractWidgetStrategy
{
    protected $parameterRepository;

    public function __construct(ParameterRepositoryInterface $parameterRepository)
    {
        $this->parameterRepository = $parameterRepository;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        return $this->render($widget);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'template' => '@SymEdit/Widget/contact-info.html.twig',
        ));
    }

    public function getCacheOptions(WidgetInterface $widget)
    {
        $updatedAt = $this->parameterRepository->getLastUpdated();

        // No settings yet
        if (!$updatedAt) {
            return parent::getCacheOptions($widget);
        }

        return array(
            'public' => true,
            'last_modified' => $updatedAt,
        );
    }

    public function getName()
    {
        return 'contact_info';
    }

    public function getDescription()
    {
        return 'core.contact_info';
    }
}
