<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ShortcodeBundle\Twig\Extension;

use SymEdit\Bundle\ShortcodeBundle\Renderer\ShortcodeRendererInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ShortcodeExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('shortcode', array($this, 'renderShortcodes')),
        );
    }

    /**
     * @return ShortcodeRendererInterface
     */
    protected function getRenderer()
    {
        return $this->container->get('symedit_shortcode.renderer');
    }

    public function renderShortcodes($string)
    {
        return $this->getRenderer()->renderString($string);
    }

    public function getName()
    {
        return 'symedit_shortcode';
    }
}
