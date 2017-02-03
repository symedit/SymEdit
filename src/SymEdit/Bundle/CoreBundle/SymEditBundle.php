<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\ExpressionLanguageCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\LinkShortcodeCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\MailerCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\RouterCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\SymEditExtensionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigExceptionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\TwigPathCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler\WidgetTwigExtensionCompilerPass;
use SymEdit\Bundle\CoreBundle\DependencyInjection\SymEditExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class SymEditBundle extends AbstractResourceBundle
{
    private $kernel;

    public function __construct(Kernel $kernel = null)
    {
        if ($kernel === null) {
            throw new \RuntimeException(
                'When you register the SymEdit bundle, be sure to include "$this" in the parameters => '.
                'new SymEdit\\Bundle\\CoreBundle\\SymEditBundle($this)'
            );
        }

        $this->kernel = $kernel;
    }

    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RouterCompilerPass());
        $container->addCompilerPass(new TwigExceptionCompilerPass());
        $container->addCompilerPass(new TwigPathCompilerPass($this->kernel));
        $container->addCompilerPass(new SymEditExtensionCompilerPass());
        $container->addCompilerPass(new LinkShortcodeCompilerPass());
        $container->addCompilerPass(new ExpressionLanguageCompilerPass());
        $container->addCompilerPass(new WidgetTwigExtensionCompilerPass());
        $container->addCompilerPass(new MailerCompilerPass());
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\CoreBundle\Model';
    }

    protected function getBundlePrefix()
    {
        return 'symedit';
    }

    public function getContainerExtension()
    {
        return new SymEditExtension();
    }
}
