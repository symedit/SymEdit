<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

class EntityPropertyType extends AbstractType
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'property_value',
            'property',
            'class',
        ]);

        $doctrine = $this->doctrine;

        $choiceList = function (Options $options) use ($doctrine) {
            $entities = $doctrine->getManager()->getRepository($options['class'])->findAll();

            $choices = [];
            $accessor = PropertyAccess::createPropertyAccessor();
            $i = 0;

            foreach ($entities as $entity) {
                if ($options['property_value'] !== null) {
                    $key = $accessor->getValue($entity, $options['property_value']);
                } else {
                    $key = $i++;
                }

                $choices[$key] = $accessor->getValue($entity, $options['property']);
            }

            return new SimpleChoiceList($choices);
        };

        $resolver->setDefaults([
            'property_value' => null,
            'choice_list' => $choiceList,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'entity_property';
    }
}
