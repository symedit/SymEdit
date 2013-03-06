<?php

namespace Isometriks\Bundle\SymEditBundle\Util;

class Util
{
    static public function slugify($text, $max = null, $char = '-')
    {
        $text = preg_replace('~[^\\pL\d]+~u', $char, $text);
        $text = trim($text, $char);
        $text = strtolower($text);
        $text = preg_replace('~[^' . $char . '\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        if (isset($max) && is_int($max)) {
            $text = substr($text, 0, $max);
        }

        return $text;
    }
}