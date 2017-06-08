<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Twig\Extension;

use SymEdit\Bundle\StylizerBundle\Dumper\VersionManager;
use SymEdit\Bundle\StylizerBundle\Model\Styles;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StylizerExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('google_fonts', [$this, 'renderGoogleFonts'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @return Styles
     */
    protected function getStyles()
    {
        return $this->container->get('symedit_stylizer.styles');
    }

    public function renderGoogleFonts()
    {
        // @TODO: Have this save google fonts instead and then fetch it when we need it?
        $variables = $this->getStyles()->getVariables();

        if (!isset($variables['google-fonts'])) {
            return;
        }

        $fonts = trim($variables['google-fonts'], '\'\"');

        if ($fonts === null || empty($fonts) || $fonts === 'none') {
            return;
        }

        return sprintf('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=%s">', $fonts);
    }

    /**
     * @return VersionManager
     */
    public function getVersionManager()
    {
        return $this->container->get('symedit_stylizer.version_manager');
    }

    public function getName()
    {
        return 'stylizer_extension';
    }
}
