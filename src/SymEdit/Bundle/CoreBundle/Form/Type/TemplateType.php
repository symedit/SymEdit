<?php

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Yaml\Yaml;
use SymEdit\Bundle\CoreBundle\Finder\ResourceFinder;
use SymEdit\Bundle\CoreBundle\Layout\Layout;

class TemplateType extends AbstractType
{
    private $finder;
    private $kernel;

    public function __construct(ResourceFinder $finder, Kernel $kernel)
    {
        $this->finder = $finder;
        $this->kernel = $kernel;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $templates = $this->finder->getTemplates();
        $layouts = array();

        /**
         * Check if this is empty, if it is use default value
         */
        if ($form->getData() === null) {
            $view->vars['value'] = $options['default_template'];
        }

        foreach ($templates as $template) {
            try {
                $path = $this->kernel->locateResource(sprintf('@SymEditBundle/Resources/layout/%s.yml', $template->getFilename()));
                $layouts[$template->getFilename()] = new \SplFileInfo($path);
            } catch (\InvalidArgumentException $e) {
                $layouts[$template->getFilename()] = null;
            }
        }

        $view->vars['layouts'] = $this->parseLayouts($layouts, $view->vars['value']);
    }

    private function parseLayouts(array $layouts, $active)
    {
        $parsed = array();

        foreach ($layouts as $templateFile => $layoutFile) {

            if ($layoutFile === null) {
                $layout = new Layout($templateFile, 'No Description Available', $templateFile, array('b', 'b'));
            } else {
                $yaml = Yaml::parse(file_get_contents($layoutFile));
                $layout = new Layout($yaml['title'], $yaml['description'], $templateFile, $yaml['rows']);
            }

            if ($active === $templateFile) {
                $layout->setActive(true);
            }

            $parsed[] = $layout;
        }

        return $parsed;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'default_template' => 'base.html.twig',
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
        return 'symedit_template';
    }
}