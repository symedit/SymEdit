<?php

namespace Isometriks\Bundle\SeoBundle\Util;

class SeoTools
{
    public function limit($length, $showElipsis, $elipsis = '...')
    {
        // idk
    }
    
    public static function normalize($string)
    {
        return htmlentities(strip_tags($string));
    }
}