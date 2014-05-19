<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
