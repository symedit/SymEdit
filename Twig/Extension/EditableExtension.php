<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Isometriks\Bundle\SymEditBundle\Editable\Editable;
use Isometriks\Bundle\SymEditBundle\Twig\TokenParser;

class EditableExtension extends \Twig_Extension
{
    private $container;
    private $form_factory;
    private $security;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->security = $this->container->get('security.context');
        $this->form_factory = $this->container->get('form.factory');
    }
    
    private function getEditableRegistry()
    {
        return $this->container->get('isometriks_sym_edit.editable.registry'); 
    }

    public function render($subject, $type, array $parameters = array())
    {
        $editable = new Editable($subject, $type, $parameters);
        $extension = $this->registry->getExtensionForType($editable);

        return $extension->execute($editable, $this->form_factory, $this->security);
    }

    public function getFunctions()
    {
        return array(
            'editable_scripts' => new \Twig_Function_Method($this, 'getJavascripts'),
            'editable_sheets' => new \Twig_Function_Method($this, 'getStylesheets'),
        );
    }

    public function getJavascripts()
    {
        $scripts = array();

        foreach ($this->getEditableRegistry()->getLoadedExtensions() as $extension) {
            $scripts = array_merge($scripts, $extension->getJavascripts());
        }

        return array_unique($scripts);
    }

    public function getStylesheets()
    {
        $sheets = array();

        foreach ($this->getEditableRegistry()->getLoadedExtensions() as $extension) {
            $sheets = array_merge($sheets, $extension->getStylesheets());
        }

        return array_unique($sheets);
    }

    public function getTokenParsers()
    {
        return array(
            new TokenParser\ContentTokenParser(),
            new TokenParser\ChunkTokenParser(),
        );
    }

    public function getName()
    {
        return 'symedit_editable';
    }
}