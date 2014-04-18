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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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

        // Sort by key so directories will be next to each other
        ksort($templates);

        $view->vars['templates'] = $templates;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => 'base.html.twig',
            'directory' => 'Page',
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