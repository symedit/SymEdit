<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Form\Type;

use SymEdit\Bundle\ThemeBundle\Model\LayoutManager;
use SymEdit\Bundle\ThemeBundle\Model\TemplateManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateType extends AbstractType
{
    protected $templateManager;
    protected $layoutManager;

    public function __construct(TemplateManager $templateManager, LayoutManager $layoutManager)
    {
        $this->templateManager = $templateManager;
        $this->layoutManager = $layoutManager;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $templates = $this->templateManager->getTemplates($options['directory']);

        // The layout manager injects the layout if it finds one
        array_map(array($this->layoutManager, 'getLayout'), $templates);

        $view->vars['templates'] = $this->templateManager->getTemplateTree($options['directory']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Set the default value if none is set
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            if ($event->getData() === null) {
                $event->setData($options['default_template']);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'default_template' => 'base.html.twig',
            'directory' => 'Page',
            'attr' => array(
                'data-toggle' => 'template-target',
            ),
        ));
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'template';
    }
}
