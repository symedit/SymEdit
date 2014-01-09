<?php

namespace Isometriks\Bundle\SeoBundle\Model; 

interface SeoAbleInterface
{
    /**
     * @return SeoInterface|array
     */
    public function getSeo(); 
}