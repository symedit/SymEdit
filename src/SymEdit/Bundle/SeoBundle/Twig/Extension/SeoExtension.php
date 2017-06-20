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

use SymEdit\Bundle\SeoBundle\Model\SeoInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoManagerInterface;
use SymEdit\Bundle\SeoBundle\Util\SeoTools;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SeoExtension extends \Twig_Extension
{
    protected $container;
    protected $calculatedSeo;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('symedit_seo_title', [$this, 'getSeoTitle'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('symedit_seo_metas', [$this, 'getSeoMetas'], ['is_safe' => ['html']]),
        ];
    }

    public function getSeoTitle()
    {
        return SeoTools::normalize($this->getCalculatedSeo()->getTitle());
    }

    public function getSeoMetas()
    {
        $metas = [];

        foreach ($this->getCalculatedSeo()->getMetas() as $type => $tag) {
            foreach ($tag as $key => $content) {
                $metas[] = sprintf('<meta %s="%s" content="%s">', $type, $key, SeoTools::normalize($content));
            }
        }

        return $metas;
    }

    /**
     * @return SeoInterface
     */
    protected function getCalculatedSeo()
    {
        if ($this->calculatedSeo === null) {
            $this->calculatedSeo = $this->getSeoManager()->getCalculatedSeo($this->getRequest());
        }

        return $this->calculatedSeo;
    }

    /**
     * @return SeoManagerInterface
     */
    protected function getSeoManager()
    {
        return $this->container->get('symedit_seo.seo_manager');
    }

    public function getName()
    {
        return 'symedit_seo';
    }
}
