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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
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
        $view->vars = array_merge($view->vars, [
            'templates' => $this->templateManager->getTemplateTree($options['directory']),
            'namespace' => $options['namespace'],
            'display_layouts' => $options['display_layouts'],
            'layout_manager' => $this->layoutManager,
        ]);
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
        $resolver->setDefaults([
            'namespace' => 'Theme',
            'display_layouts' => false,
            'default_template' => 'base.html.twig',
            'attr' => [
                'data-toggle' => 'template-target',
            ],
        ]);


        $resolver->setRequired('directory');
        $resolver->setRequired('namespace');

        // Get Choice Normalizer
        $normalizer = function (Options $options) {
            $choices = [];

            foreach ($this->templateManager->getTemplates($options['directory']) as $template) {
                $name = sprintf('@%s/%s', $options['namespace'], $template->getKey());
                $layout = $this->layoutManager->getLayout($template);
                $choices[$name] = $layout->getTitle();
            }

            return $choices;
        };

        $resolver->setNormalizer('choices', $normalizer);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'template';
    }
}
