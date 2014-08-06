<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use SymEdit\Bundle\StylizerBundle\Model\Stylizer;
use SymEdit\Bundle\StylizerBundle\Loader\GroupData;
use Symfony\Component\Validator\Constraints\NotBlank;

class StylesType extends AbstractType
{
    protected $stylizer;

    public function __construct(Stylizer $stylizer)
    {
        $this->stylizer = $stylizer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groups = $this->stylizer->getConfigData()->getGroups();

        $allGroups = $builder->create('groups', 'form', array(
            'virtual' => true,
        ));

        foreach ($groups as $groupName => $group) {

            $groupOptions = array(
                'virtual' => true,
                'extra' => $group->getExtra(),
            );

            if ($group->getLabel() !== null) {
                $groupOptions['label'] = $group->getLabel();
            }

            $groupForm = $builder->create('group_'.$groupName, new GroupType(), $groupOptions);
            $this->addVariables($groupForm, $group);

            $allGroups->add($groupForm);
        }

        $builder->add($allGroups);
    }

    private function addVariables(FormBuilderInterface $builder, GroupData $group)
    {
        $config = $group->getVariableConfig();

        foreach ($config as $name => $data) {

            $label = isset($data['label']) ? $data['label'] : '';
            $options = isset($data['options']) ? $data['options'] : array();
            $type = isset($data['type']) ? $data['type'] : 'text';
            $constraints = array();

            if (!isset($options['required']) || $options['required']) {
                $constraints = array(
                    new NotBlank(),
                );
            }

            $builder->add($name, $type, array_merge(
                array(
                    'label' => $label,
                    'property_path' => sprintf('[%s]', $name),
                    'constraints' => $constraints,
                ),
                $options
            ));
        }
    }

    public function getName()
    {
        return 'symedit_stylizer';
    }
}
