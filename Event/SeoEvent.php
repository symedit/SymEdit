<?php

namespace Isometriks\Bundle\SeoBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SeoBundle\Model\SeoInterface;

class SeoEvent extends Event
{
    protected $seo;
    protected $request;
    
    public function __construct(SeoInterface $seo, Request $request = null)
    {
        $this->seo = $seo;
        $this->request = $request;
    }

    /**
     * Get the request
     * 
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the current Seo instance
     * 
     * @return SeoInterface
     */
    public function getSeo()
    {
        return $this->seo;
    }    
    
    /**
     * Replace the current Seo instance
     * 
     * @param SeoInterface $seo
     */
    public function setSeo(SeoInterface $seo)
    {
        $this->seo = $seo;
    }
}