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
        return array(
            new \Twig_SimpleFunction('google_fonts', array($this, 'renderGoogleFonts'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('stylizer_asset', array($this, 'getAssetUrl')),
        );
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

        return sprintf('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=%s">', $fonts);
    }

    /**
     * @return VersionManager
     */
    public function getVersionManager()
    {
        return $this->container->get('symedit_stylizer.version_manager');
    }

    public function getAssetUrl($url)
    {
        // Get stylizer version as string
        $stylizerVersion = $this->getVersionManager()->getVersion();

        if ($stylizerVersion === null) {
            return $url;
        }

        // @TODO: Maybe move this logic to the versionmanager? Pass it the url?
        $query = parse_url($url, PHP_URL_QUERY);
        $queryVersion = $query === null ? $stylizerVersion : $query.$stylizerVersion;
        $versionUrl = strtok($url, '?').'?'.$queryVersion;

        return $versionUrl;
    }

    public function getName()
    {
        return 'stylizer_extension';
    }
}
