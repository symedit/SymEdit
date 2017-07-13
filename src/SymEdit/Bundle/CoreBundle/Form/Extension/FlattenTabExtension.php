<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Extension;

use Mopa\Bundle\BootstrapBundle\Form\Type\TabType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This extension will see if tabs_data is defined and if it is, will
 * attempt to build tabs based on these settings. If build_tabs is enabled
 * then it will create the tabs, if not it will bypass. This assumes that
 * every tab that is made uses inherit_data so it basically only functions
 * on one object at a time but broken into pieces.
 */
class FlattenTabExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Creatd with createNamed('', ...) so likely an API request, might
        // need to make this a little better in the future
        $buildTabs = $builder->getName() === '' ? false : $options['build_tabs'];
        $tabsData = $options['tabs_data'];
        $formType = $builder->getType()->getInnerType();

        $tabDefaults = [
            'inherit_data' => true,
        ];

        foreach ($tabsData as $name => $data) {
            $tabOptions = array_merge($tabDefaults, $data);
            $forceTab = isset($data['force_tab']) ? $data['force_tab'] : false;

            // Remove unused option
            if ($forceTab) {
                unset($tabOptions['force_tab']);
            }

            // Build Tab
            if ($buildTabs || $forceTab) {
                $parent = $builder->create($name, TabType::class, $tabOptions);
                $builder->add($parent);

            // Just add it to the main form
            } else {
                $parent = $builder;
            }

            // Get method name
            $method = sprintf('build%sForm', ucfirst($name));

            if (!method_exists($formType, $method)) {
                throw new \InvalidArgumentException(
                    sprintf('Method "%s" does not exist in "%s"', $method, get_class($formType))
                );
            }

            // call buildTabNameForm
            call_user_func([$formType, $method], $parent, $options, $builder->getData());
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'build_tabs' => true,
            'tabs_data' => [],
        ]);
    }

    public function getExtendedType()
    {
        return FormType::class;
    }
}
