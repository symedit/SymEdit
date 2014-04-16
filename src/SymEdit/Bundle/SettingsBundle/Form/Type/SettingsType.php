<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\Security\Core\SecurityContext;

class SettingsType extends AbstractType
{
    private $settings;
    private $context;

    public function __construct(Settings $settings, SecurityContext $context)
    {
        $this->settings = $settings;
        $this->context = $context;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groups = $builder->create('groups', 'form', array(
            'inherit_data' => true,
        ));

        $config = $this->settings->getConfigData();

        foreach($config as $groupName => $groupData){

            // Check for roles
            if ($groupData['role'] !== null && !$this->context->isGranted($groupData['role'])){
                continue;
            }

            $groupForm = $builder->create($groupName, 'form', array(
                'inherit_data' => true,
                'label' => $groupData['label'],
            ));

            foreach($groupData['settings'] as $settingName => $settingData){
                $groupForm->add($settingName, $settingData['type'], array_replace_recursive($groupData['default_options'], array(
                        'property_path' => sprintf('[%s][%s]', $groupName, $settingName),
                    ),
                    $settingData['options']
                ));
            }

            $groups->add($groupForm);
        }

        $builder->add($groups);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'method' => 'PUT',
        ));
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'settings';
    }
}