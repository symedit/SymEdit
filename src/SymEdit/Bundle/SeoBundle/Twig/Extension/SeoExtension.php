<?php

namespace Isometriks\Bundle\SeoBundle\Twig\Extension;

use Isometriks\Bundle\SeoBundle\Model\SeoManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SeoBundle\Util\SeoTools;

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
            new \Twig_SimpleFunction('isometriks_seo_title', array($this, 'getSeoTitle')),
            new \Twig_SimpleFunction('isometriks_seo_metas', array($this, 'getSeoMetas'), array('is_safe' => array('html'))),
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
     * @return Isometriks\Bundle\SeoBundle\Model\SeoInterface
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
        return 'isometriks_seo';
    }
}