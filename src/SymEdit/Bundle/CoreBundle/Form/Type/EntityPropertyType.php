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


        $resolver->setDefaults([
            'property_value' => null,
            'choices' => function (Options $options) {
                return $this->doctrine->getManager()->getRepository($options['class'])->findAll();
            }
        ]);

        // Create Accessor
        $accessor = PropertyAccess::createPropertyAccessor();

        // Get Choice Values
        $resolver->setNormalizer('choice_value', function (Options $options) use ($accessor) {
            $i = 0;

            return function($entity) use ($options, $accessor, &$i) {
                if ($entity === null) {
                    return;
                }

                if ($options['property_value'] !== null) {
                    return $accessor->getValue($entity, $options['property_value']);
                }

                return $i++;
            };
        });

        // Get Choice Labels
        $resolver->setNormalizer('choice_label', function (Options $options) use ($accessor) {
            return function($entity, $key, $index) use ($options, $accessor) {
                return $accessor->getValue($entity, $options['property']);
            };
        });
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
