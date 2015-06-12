<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MailChimpBundle\Widget\Strategy;

use SymEdit\Bundle\MailChimpBundle\Form\Type\SubscribeType;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class SubscribeStrategy extends AbstractWidgetStrategy
{
    protected $formFactory;
    protected $router;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    public function execute(WidgetInterface $widget)
    {
        $form = $this->formFactory->create(new SubscribeType(), null, array(
            'action' => $this->router->generate('symedit_mailchimp_subscribe'),
            'method' => 'POST',
            'list' => $widget->getOption('list'),
        ));

        return $this->render('@SymEdit/Widget/MailChimp/subscribe-form.html.twig', array(
            'form' => $form->createView(),
            'placeholder' => $widget->getOption('placeholder'),
            'button_text' => $widget->getOption('button_text'),
        ));
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'placeholder' => 'you@email.com',
            'button_text' => 'Subscribe!',
        ));
    }

    public function getCacheOptions(WidgetInterface $widget)
    {
        return array(
            'private' => true,
        );
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('list', 'mailchimp_list')
            ->add('placeholder', 'text')
            ->add('button_text', 'text')
        ;
    }

    public function getName()
    {
        return 'mailchimp_subscribe';
    }

    public function getDescription()
    {
        return 'mailchimp.subscribe';
    }
}
