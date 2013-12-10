<?php

/*
 * This file is part of SymEdit
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 */

namespace Isometriks\Bundle\MediaBundle\Util;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

class ImageManipulator
{
    private $webRoot;

    public function __construct($webRoot)
    {
        $this->webRoot = $webRoot;
    }

    public function constrain($image, $args)
    {
        $image_src = sprintf('%s/%s', $this->webRoot, ltrim($image, '/'));
        $image_web = $image;

        $info = pathinfo($image);
        $image_dir = isset($info['dirname']) ? $info['dirname'] : null;

        if (!file_exists($image_src)) {
            return $this->error('Not Found: '. $image_src);
        }

        $nw = isset($args['width'])  ? $args['width']  : (isset($args['w']) ? $args['w'] : false);
        $nh = isset($args['height']) ? $args['height'] : (isset($args['h']) ? $args['h'] : false);

        try {
            list( $w, $h ) = \getimagesize($image_src);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }

        if ($h == 0) {
            return $this->error('no-height');
        }

        $ratio = $w / $h;

        // Figure out which one to constrain
        if ($nw !== false && $nh !== false) {
            $xr = $nw / $w;
            $yr = $nh / $h;

            if (($w <= $nw) && ($h <= $nh )) {
                $nw = $nh = false;
            } else if (($xr * $h) < $nh) {
                $nh = false;
            } else {
                $nw = false;
            }
        }

        if ($nw !== false) {

            if ($w <= $nw) {
                return $image_web;
            }

            $pre = 'w' . $nw;
            $nh = $nw / $ratio;
        } else if ($nh !== false) {

            if ($h <= $nh) {
                return $image_web;
            }

            $pre = 'h' . $nh;
            $nw = $nh * $ratio;
        } else {
            return $image_web;
        }

        $info = pathinfo($image_src);
        $filename = sprintf('%s_%s.%s', $info['filename'], $pre, 'png');

        $output_dir = sprintf('%s/%s', $info['dirname'], 'cache');
        $output_file = sprintf('%s/%s', $output_dir, $filename);
        $web_file = sprintf('%s/%s/%s', $image_dir, 'cache', $filename);

        if (!is_dir($output_dir)) {
            mkdir($output_dir);
            chmod($output_dir, 0755);
        }

        // Does it already exist? Just return it if so!
        if (file_exists($output_file)) {
            return $web_file;
        }

        $resized = \imagecreatetruecolor($nw, $nh);

        \imagealphablending($resized, false);
        \imagesavealpha($resized, true);

        \imagecopyresampled($resized, $this->loadImage($image_src), 0, 0, 0, 0, $nw, $nh, $w, $h);

        \imagepng($resized, $output_file);
        chmod($output_file, 0644);

        return $web_file;
    }

    private function error($image_src = '')
    {
        return sprintf('image-error-%s.jpg', $image_src);
    }

    private function loadImage($image_src)
    {

        if (file_exists($image_src)) {
            $contents = file_get_contents($image_src);
            $image = \imagecreatefromstring($contents);

            return $image;
        }

        return null;
    }

}

