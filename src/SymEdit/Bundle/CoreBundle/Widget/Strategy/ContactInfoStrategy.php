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

use SymEdit\Bundle\CoreBundle\Repository\SettingsRepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactInfoStrategy extends AbstractWidgetStrategy
{
    protected $settingsRepository;

    public function __construct(SettingsRepositoryInterface $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function execute(WidgetInterface $widget)
    {
        return $this->render($widget);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SymEdit/Widget/contact-info.html.twig',
        ]);
    }

    public function getCacheOptions(WidgetInterface $widget)
    {
        $updatedAt = $this->settingsRepository->getLastUpdated();

        // No settings yet
        if (!$updatedAt) {
            return parent::getCacheOptions($widget);
        }

        return [
            'public' => true,
            'last_modified' => $updatedAt,
        ];
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
