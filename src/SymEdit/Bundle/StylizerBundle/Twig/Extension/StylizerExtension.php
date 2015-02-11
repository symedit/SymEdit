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

class StylizerExtension extends \Twig_Extension
{
    protected $styles;
    protected $versionManager;

    public function __construct(Styles $styles, VersionManager $versionManager)
    {
        $this->styles = $styles;
        $this->versionManager = $versionManager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('google_fonts', array($this, 'renderGoogleFonts'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('stylizer_asset', array($this, 'getAssetUrl')),
        );
    }

    public function renderGoogleFonts()
    {
        $variables = $this->styles->getVariables();

        if (!isset($variables['google-fonts'])) {
            return;
        }

        $fonts = trim($variables['google-fonts'], '\'\"');

        if ($fonts === null || empty($fonts) || $fonts === 'none') {
            return;
        }

        return sprintf('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=%s">', $fonts);
    }

    public function getAssetUrl($url)
    {
        // Get stylizer version as string
        $stylizerVersion = $this->versionManager->getVersion();

        if ($stylizerVersion === null) {
            return $url;
        }

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
