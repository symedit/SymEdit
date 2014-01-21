<?php

namespace Isometriks\Bundle\MediaBundle\Twig\Extension;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Isometriks\Bundle\MediaBundle\Util\ImageManipulator;

class MediaExtension extends \Twig_Extension
{
    private $manip;

    public function __construct(ImageManipulator $manip)
    {
        $this->manip = $manip;
    }

    public function getFilters()
    {
        return array(
            'constrain' => new \Twig_Filter_Method($this, 'imageConstrain'),
        );
    }

    public function imageConstrain($src, $args)
    {
        // If you try to constrain an Image object directly
        if ($src instanceof MediaInterface) {
            $src = $src->getWebPath();
        }

        return $this->manip->constrain($src, $args);
    }

    public function getName()
    {
        return 'IsometriksMediaExtension';
    }
}