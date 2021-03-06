<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\SymEdit\Bundle\SettingsBundle\Form\Factory;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Registry\ServiceRegistryInterface;
use SymEdit\Bundle\SettingsBundle\Form\Factory\SettingsFormFactory;
use SymEdit\Bundle\SettingsBundle\Form\Factory\SettingsFormFactoryInterface;
use SymEdit\Bundle\SettingsBundle\Schema\SchemaInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
final class SettingsFormFactorySpec extends ObjectBehavior
{
    function let(
        ServiceRegistryInterface $schemaRegistry,
        FormFactoryInterface $formFactory
    ) {
        $this->beConstructedWith($schemaRegistry, $formFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SettingsFormFactory::class);
    }

    function it_implements_settings_form_factory_interface()
    {
        $this->shouldImplement(SettingsFormFactoryInterface::class);
    }

    function it_should_create_a_form_for_given_schema_namespace(
        FormInterface $form,
        FormBuilder $formBuilder,
        FormFactoryInterface $formFactory,
        SchemaInterface $schema,
        ServiceRegistryInterface $schemaRegistry
    ) {
        $schemaRegistry->get('sylius_general')->willReturn($schema);
        $formFactory->createBuilder('form', null, ['data_class' => null])->willReturn($formBuilder);
        $schema->buildForm($formBuilder)->shouldBeCalled()->willReturn($formBuilder);
        $formBuilder->getForm()->willReturn($form);

        $this->create('sylius_general')->shouldReturn($form);
    }
}
