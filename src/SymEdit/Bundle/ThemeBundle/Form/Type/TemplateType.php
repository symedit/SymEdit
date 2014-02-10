<?php

namespace SymEdit\Bundle\ThemeBundle\Form\Type;

use SymEdit\Bundle\ThemeBundle\Model\TemplateManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    protected $templateManager;

    public function __construct(TemplateManager $templateManager)
    {
        $this->templateManager = $templateManager;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['templates'] = $this->templateManager->getTemplates($options['directory']);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => 'base.html.twig',
            'directory' => 'Page',
            'choices' => function(Options $options) {
                $templates = $this->templateManager->getTemplates($options['directory']);
                ksort($templates);

                return $templates;
            },
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'template';
    }
}