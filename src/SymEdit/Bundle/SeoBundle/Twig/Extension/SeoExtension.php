<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Twig\Extension;

use SymEdit\Bundle\SeoBundle\Model\SeoManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use SymEdit\Bundle\SeoBundle\Util\SeoTools;

class SeoExtension extends \Twig_Extension
{
    protected $seoManager;
    protected $calculatedSeo;
    protected $request;

    public function __construct(SeoManagerInterface $seoManager)
    {
        $this->seoManager = $seoManager;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('symedit_seo_title', array($this, 'getSeoTitle')),
            new \Twig_SimpleFunction('symedit_seo_metas', array($this, 'getSeoMetas'), array('is_safe' => array('html'))),
        );
    }

    public function getSeoTitle()
    {
        return $this->getCalculatedSeo()->getTitle();
    }

    public function getSeoMetas()
    {
        $metas = array();

        foreach ($this->getCalculatedSeo()->getMetas() as $type => $tag) {
            foreach ($tag as $key => $content) {
                $metas[] = sprintf('<meta %s="%s" content="%s">', $type, $key, SeoTools::normalize($content));
            }
        }

        return $metas;
    }

    /**
     * @return SymEdit\Bundle\SeoBundle\Model\SeoInterface
     */
    protected function getCalculatedSeo()
    {
        if ($this->calculatedSeo === null) {
            $this->calculatedSeo = $this->seoManager->getCalculatedSeo($this->request);
        }

        return $this->calculatedSeo;
    }

    public function getName()
    {
        return 'symedit_seo';
    }
}
