<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

interface SeoAbleInterface
{
    public function setSeo(array $seo = array()); 
    public function getSeo(); 
}