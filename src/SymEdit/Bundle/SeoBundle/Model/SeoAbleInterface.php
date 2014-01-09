<?php

namespace SymEdit\Bundle\SeoBundle\Model; 

interface SeoAbleInterface
{
    /**
     * @return SeoInterface|array
     */
    public function getSeo(); 
}