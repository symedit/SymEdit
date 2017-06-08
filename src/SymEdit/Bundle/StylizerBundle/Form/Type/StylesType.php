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

use SymEdit\Bundle\StylizerBundle\Loader\GroupData;
use SymEdit\Bundle\StylizerBundle\Model\StyleManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class StylesType extends AbstractType
{
    protected $manager;
    protected $mappings;

    public function __construct(StyleManager $manager, array $mappings)
    {
        $this->manager = $manager;
        $this->mappings = $mappings;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groups = $this->manager->getConfigData()->getGroups();

        $allGroups = $builder->create('groups', FormType::class, [
            'inherit_data' => true,
            'label' => false,
        ]);

        foreach ($groups as $groupName => $group) {
            $groupOptions = [
                'inherit_data' => true,
                'extra' => $group->getExtra(),
            ];

            if ($group->getLabel() !== null) {
                $groupOptions['label'] = $group->getLabel();
            }

            $groupForm = $builder->create('group_'.$groupName, GroupType::class, $groupOptions);
            $this->addVariables($groupForm, $group);

            $allGroups->add($groupForm);
        }

        $builder->add($allGroups);
    }

    private function addVariables(FormBuilderInterface $builder, GroupData $group)
    {
        $config = $group->getVariableConfig();

        foreach ($config as $name => $data) {
            $this->addVariable($builder, $name, $data);
        }
    }

    private function addVariable(FormBuilderInterface $builder, $name, $data)
    {
        $label = isset($data['label']) ? $data['label'] : '';
        $options = isset($data['options']) ? $data['options'] : [];
        $type = isset($data['type']) ? $data['type'] : 'text';
        $constraints = [];

        if (!isset($options['required']) || $options['required']) {
            $constraints = [
                new NotBlank(),
            ];
        }

        if (!isset($this->mappings[$type])) {
            throw new \InvalidArgumentException(sprintf('Stylizer form type "%s" not mapped to a form class', $type));
        }

        // Get fqcn for form type
        $fqcn = $this->mappings[$type];

        $builder->add($name, $fqcn, array_merge([
            'label' => $label,
            'property_path' => sprintf('[%s]', $name),
            'constraints' => $constraints,
        ], $options));
    }

    public function getBlockPrefix()
    {
        return 'symedit_stylizer';
    }
}
