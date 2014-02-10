<?php

namespace SymEdit\Bundle\ThemeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class BundleTemplateLoaderDefinition extends Definition
{
    public function __construct($bundle)
    {
        parent::__construct();

        $this
            ->setClass('%symedit_theme.template.loader.bundle.class%')
            ->addTag('symedit_theme.template_loader')
            ->addArgument($bundle)
            ->addArgument(new Reference('kernel'))
            ->setPublic(false);
    }
}